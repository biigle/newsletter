<?php

namespace Biigle\Tests\Modules\Newsletter\Console\Commands;

use Biigle\Modules\Newsletter\NewsletterSubscriber;
use TestCase;

class PruneStaleSubscribersTest extends TestCase
{
    public function testHandle()
    {
        $subscriber1 = NewsletterSubscriber::factory()->create([
            'created_at' => now()->subWeeks(3),
        ]);
        $subscriber2 = NewsletterSubscriber::factory()->create([
            'created_at' => now()->subDay(),
        ]);
        $subscriber3 = NewsletterSubscriber::factory()->create([
            'created_at' => now()->subWeeks(3),
            'email_verified_at' => now()->subWeeks(1),
        ]);

        $this->artisan('newsletter:prune-stale')->assertExitCode(0);

        $this->assertModelMissing($subscriber1);
        $this->assertModelExists($subscriber2);
        $this->assertModelExists($subscriber3);

    }
}
