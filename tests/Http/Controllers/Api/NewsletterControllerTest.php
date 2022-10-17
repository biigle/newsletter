<?php

namespace Biigle\Tests\Modules\Newsletter\Http\Controllers\Api;

use ApiTestCase;
use Biigle\Modules\Newsletter\Newsletter;

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
}
