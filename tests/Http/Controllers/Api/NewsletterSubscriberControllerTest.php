<?php

namespace Biigle\Tests\Modules\Newsletter\Http\Controllers\Api;

use ApiTestCase;
use Biigle\Modules\Newsletter\NewsletterSubscriber;

class NewsletterSubscriberControllerTest extends ApiTestCase
{
    public function testDestroy()
    {
        $subscriber = NewsletterSubscriber::factory()->create();
        $id = $subscriber->id;

        $this->doTestApiRoute('DELETE', "/api/v1/newsletter-subscribers/{$id}");

        $this->beAdmin();
        $this->deleteJson("/api/v1/newsletter-subscribers/{$id}")->assertStatus(403);

        $this->beGlobalAdmin();
        $this->deleteJson("/api/v1/newsletter-subscribers/{$id}")
            ->assertStatus(200);

        $this->assertNull($subscriber->fresh());
    }
}
