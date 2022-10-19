<?php

namespace Biigle\Tests\Modules\Newsletter\Http\Controllers\Api;

use ApiTestCase;
use Biigle\Modules\Newsletter\Newsletter;
use Biigle\Modules\Newsletter\NewsletterSubscriber;
use Biigle\Modules\Newsletter\Notifications\NewNewsletter;
use Illuminate\Support\Facades\Notification;

class NewsletterControllerTest extends ApiTestCase
{
    public function testStore()
    {
        $this->doTestApiRoute('POST', "/api/v1/newsletters");

        $this->beAdmin();
        $this->postJson("/api/v1/newsletters")->assertStatus(403);

        $this->beGlobalAdmin();
        $this->postJson("/api/v1/newsletters")->assertStatus(422);

        $this->assertEquals(0, Newsletter::count());

        $this->postJson("/api/v1/newsletters", [
                'subject' => 'My first newsletter',
                'body' => "# Header\nText",
            ])
            ->assertStatus(201);

        $n = Newsletter::first();
        $this->assertNotNull($n);
        $this->assertEquals('My first newsletter', $n->subject);
        $this->assertEquals("# Header\nText", $n->body);
        $this->assertNull($n->published_at);

        // Only a single draft at a time allowed.
        $this->postJson("/api/v1/newsletters")->assertStatus(422);
    }

    public function testUpdate()
    {
        $n = Newsletter::factory()->create(['subject' => 'Test']);

        $this->doTestApiRoute('PUT', "/api/v1/newsletters/{$n->id}");

        $this->beAdmin();
        $this->putJson("/api/v1/newsletters/{$n->id}")->assertStatus(403);

        $this->beGlobalAdmin();
        $this->putJson("/api/v1/newsletters/{$n->id}")->assertStatus(422);

        $this->putJson("/api/v1/newsletters/{$n->id}", [
                'subject' => 'Text',
            ])
            ->assertStatus(200);

        $n->refresh();
        $this->assertEquals('Text', $n->subject);
    }

    public function testUpdateDraftOnly()
    {
        $n = Newsletter::factory()->create([
            'published_at' => '2022-10-17 15:36:00',
        ]);

        $this->beGlobalAdmin();
        $this->putJson("/api/v1/newsletters/{$n->id}", [
            'subject' => 'Text',
        ])->assertStatus(403);
    }

    public function testDestroyDraft()
    {
        $n = Newsletter::factory()->create();

        $this->doTestApiRoute('DELETE', "/api/v1/newsletters/{$n->id}");

        $this->beAdmin();
        $this->deleteJson("/api/v1/newsletters/{$n->id}")->assertStatus(403);

        $this->beGlobalAdmin();
        $this->deleteJson("/api/v1/newsletters/{$n->id}")->assertStatus(200);

        $this->assertNull($n->fresh());
    }

    public function testPublish()
    {
        Notification::fake();

        $verified = NewsletterSubscriber::factory()->create([
            'email_verified_at' => '2022-10-19 10:47:00',
        ]);
        $subscriber = NewsletterSubscriber::factory()->create();
        $n = Newsletter::factory()->create(['subject' => 'Test']);

        $this->doTestApiRoute('POST', "/api/v1/newsletters/{$n->id}/publish");

        $this->beAdmin();
        $this->postJson("/api/v1/newsletters/{$n->id}/publish")->assertStatus(403);

        $this->beGlobalAdmin();

        $this->assertNull($n->published_at);
        $this->postJson("/api/v1/newsletters/{$n->id}/publish")->assertStatus(200);
        $n->refresh();
        $this->assertNotNull($n->published_at);

        Notification::assertSentTo([$verified], NewNewsletter::class);
        Notification::assertNotSentTo([$subscriber], NewNewsletter::class);
    }

    public function testPublishDraftOnly()
    {
        $n = Newsletter::factory()->create(['published_at' => '2022-10-19 10:30:00']);
        $this->beGlobalAdmin();
        $this->postJson("/api/v1/newsletters/{$n->id}/publish")->assertStatus(404);
    }

    public function testDestroyPublished()
    {
        $n = Newsletter::factory()->create([
            'published_at' => '2022-10-17 15:36:00',
        ]);

        $this->beGlobalAdmin();
        $this->deleteJson("/api/v1/newsletters/{$n->id}")->assertStatus(403);
    }
}
