<?php

namespace Biigle\Tests\Modules\Newsletter\Http\Requests;

use Biigle\Modules\Newsletter\NewsletterSubscriber;
use TestCase;
use URL;
use Carbon\Carbon;

class EmailVerificationRequestTest extends TestCase
{
    public function testFulfill()
    {
        $s = NewsletterSubscriber::factory()->create();
        $url = URL::temporarySignedRoute(
            'newsletter.verify',
            Carbon::now()->addMinutes(60),
            [
                'id' => $s->getKey(),
                'hash' => sha1($s->getEmailForVerification()),
            ]
        );

        $this->assertNull($s->email_verified_at);
        $this->get($url)->assertRedirect('/newsletter/subscribed');
        $this->assertNotNull($s->fresh()->email_verified_at);
    }
}
