<?php

namespace Biigle\Tests\Modules\Newsletter\Http\Controllers;

use Biigle\Modules\Newsletter\NewsletterSubscriber;
use Biigle\Modules\Newsletter\Notifications\VerifyEmail;
use Honeypot;
use Illuminate\Support\Facades\Notification;
use Session;
use TestCase;

class RegisterControllerMixinTest extends TestCase
{
    public function testCreate()
    {
        config(['biigle.user_registration' => true]);
        Notification::fake();
        Honeypot::disable();

        $this->post('register', [
            '_token'    => Session::token(),
            'email'     => 'a@ma.il',
            'password'  => 'password',
            'firstname' => 'a',
            'lastname'  => 'b',
            'affiliation' => 'something',
            'homepage' => 'honeypotvalue',
            'newsletter' => '1',
        ])->assertRedirect();

        $this->assertEquals(1, NewsletterSubscriber::count());

        $s = NewsletterSubscriber::first();
        $this->assertNotNull($s);
        $this->assertEquals('a@ma.il', $s->email);
        $this->assertNull($s->email_verified_at);
        Notification::assertSentTo([$s], VerifyEmail::class);
    }

    public function testCreateNo()
    {
        config(['biigle.user_registration' => true]);
        Notification::fake();
        Honeypot::disable();

        $this->post('register', [
            '_token'    => Session::token(),
            'email'     => 'a@ma.il',
            'password'  => 'password',
            'firstname' => 'a',
            'lastname'  => 'b',
            'affiliation' => 'something',
            'homepage' => 'honeypotvalue',
        ])->assertRedirect();

        $this->assertEquals(0, NewsletterSubscriber::count());
        Notification::assertNothingSent();
    }

    public function testCreateDuplicate()
    {
        config(['biigle.user_registration' => true]);
        Notification::fake();
        $s = NewsletterSubscriber::factory()->create();
        Honeypot::disable();

        $this->post('register', [
            '_token'    => Session::token(),
            'email'     => $s->email,
            'password'  => 'password',
            'firstname' => 'a',
            'lastname'  => 'b',
            'affiliation' => 'something',
            'homepage' => 'honeypotvalue',
            'newsletter' => '1',
        ])->assertRedirect();

        $this->assertEquals(1, NewsletterSubscriber::count());
        Notification::assertNothingSent();
    }
}
