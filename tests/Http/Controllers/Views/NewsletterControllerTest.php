<?php

namespace Biigle\Tests\Modules\Newsletter\Http\Controllers\Views;

use Biigle\Modules\Newsletter\NewsletterSubscriber;
use Biigle\Modules\Newsletter\Notifications\VerifyEmail;
use Biigle\Modules\Newsletter\Notifications\Unsubscribed;
use Biigle\Tests\UserTest;
use Honeypot;
use Illuminate\Support\Facades\Notification;
use TestCase;
use View;

class NewsletterControllerTest extends TestCase
{
    public function testIndex()
    {
        $this->get('newsletter')->assertSuccessful();
    }

    public function testIndexLoggedIn()
    {
        $u = UserTest::create();
        $this->be($u);
        $this->get('newsletter')
            ->assertSuccessful()
            ->assertSee($u->email);
    }

    public function testCreate()
    {
        Notification::fake();
        $this->postJson('newsletter/subscribe')->assertStatus(422);

        $this->postJson('newsletter/subscribe', [
                'email' => 'joe@user.com',
                'homepage' => 'abc',
            ])
            ->assertStatus(422);

        Honeypot::disable();

        $this->assertEquals(0, NewsletterSubscriber::count());

        $this->post('newsletter/subscribe', [
                'email' => 'joe@user.com',
                'homepage' => 'abc',
            ])
            ->assertRedirect('newsletter/verify');

        $s = NewsletterSubscriber::first();
        $this->assertNotNull($s);
        $this->assertEquals('joe@user.com', $s->email);
        $this->assertNull($s->email_verified_at);
        Notification::assertSentTo([$s], VerifyEmail::class);
    }

    public function testCreateDuplicate()
    {
        Notification::fake();
        $s = NewsletterSubscriber::factory()->create();
        Honeypot::disable();
        $this->postJson('newsletter/subscribe', [
                'email' => $s->email,
                'homepage' => 'abc',
            ])
            // Works again so this can't be used to detect subscribed users.
            ->assertStatus(200);

        $this->assertEquals(1, NewsletterSubscriber::count());

        Notification::assertNothingSent();
    }

    public function testCreatePrivacy()
    {
        Notification::fake();
        Honeypot::disable();
        View::shouldReceive('exists')->with('privacy')->andReturn(true);
        View::shouldReceive('share')->passthru();
        View::shouldReceive('make')->andReturn('');
        $this->postJson('newsletter/subscribe', [
                'email' => 'joe@user.com',
                'homepage' => 'abc',
            ])
            ->assertStatus(422);

        $this->postJson('newsletter/subscribe', [
                'email' => 'joe@user.com',
                'homepage' => 'abc',
                'privacy' => '1',
            ])
            ->assertStatus(200);
    }

    public function testCreated()
    {
        $this->get('newsletter/verify')->assertSuccessful();
    }

    public function testSubscribed()
    {
        $this->get('newsletter/subscribed')->assertSuccessful();
    }

    public function testUnsubscribe()
    {
        $this->get('newsletter/unsubscribe')->assertSuccessful();
    }

    public function testDestroy()
    {
        Notification::fake();
        $this->postJson('newsletter/unsubscribe')->assertStatus(422);

        $this->postJson('newsletter/unsubscribe', [
                'email' => 'joe@user.com',
                'homepage' => 'abc',
            ])
            ->assertStatus(422);

        Honeypot::disable();

        // Works with any email address so this can't be used to detect subscribed users.
        $this->post('newsletter/unsubscribe', [
                'email' => 'joe@user.com',
                'homepage' => 'abc',
            ])
            ->assertRedirect('newsletter/unsubscribed');

        $s = NewsletterSubscriber::factory()->create();

        $this->post('newsletter/unsubscribe', [
                'email' => $s->email,
                'homepage' => 'abc',
            ])
            ->assertRedirect('newsletter/unsubscribed');

        $this->assertNull($s->fresh());
        Notification::assertSentTo([$s], Unsubscribed::class);
    }

    public function testUnsubscribed()
    {
        $this->get('newsletter/unsubscribed')->assertSuccessful();
    }
}