<?php

namespace Biigle\Tests\Modules\Newsletter\Notifications;

use Biigle\Modules\Newsletter\Newsletter;
use Biigle\Modules\Newsletter\Notifications\NewNewsletter;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Support\Facades\RateLimiter;
use TestCase;

class NewNewsletterTest extends TestCase
{
    public function testEmailRateLimiterUsesConfig()
    {
        config(['newsletter.email_rate_limit' => 3]);

        $limit = RateLimiter::limiter('newsletter-emails')();

        $this->assertSame(3, $limit->maxAttempts);
        $this->assertSame(3600, $limit->decaySeconds);
    }

    public function testMiddleware()
    {
        $notification = new NewNewsletter(Newsletter::factory()->make());

        $middleware = $notification->middleware(null, 'mail');

        $this->assertCount(1, $middleware);
        $this->assertInstanceOf(RateLimited::class, $middleware[0]);
    }

    public function testRetryUntil()
    {
        $notification = new NewNewsletter(Newsletter::factory()->make());

        $this->assertTrue($notification->retryUntil()->isFuture());
    }
}
