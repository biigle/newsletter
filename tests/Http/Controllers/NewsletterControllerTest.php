<?php

namespace Biigle\Tests\Modules\Newsletter\Http\Controllers;

use Biigle\Modules\Newsletter\NewsletterSubscriber;
use Biigle\Modules\Newsletter\Notifications\VerifyEmail;
use Biigle\Tests\UserTest;
use Honeypot;
use Illuminate\Support\Facades\Notification;
use TestCase;

class NewsletterControllerTest extends TestCase
{
    public function testIndex()
    {
        $this->get('newsletter')->assertSuccessful();
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
            ->assertStatus(200);

        $this->assertEquals(1, NewsletterSubscriber::count());

        Notification::assertNothingSent();
    }

    public function testCreated()
    {
        $this->get('newsletter/verify')->assertSuccessful();
    }

    public function testSubscribed()
    {
        $this->get('newsletter/subscribed')->assertSuccessful();
    }
}
