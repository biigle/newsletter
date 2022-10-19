<?php

namespace Biigle\Tests\Modules\Newsletter\Http\Controllers\Views;

use Biigle\Modules\Newsletter\Newsletter;
use ApiTestCase;

class NewsletterArchiveControllerTest extends ApiTestCase
{
    public function testIndex()
    {
        $n = Newsletter::factory()->create(['subject' => 'my unpublished subject']);
        $n = Newsletter::factory()->create([
            'subject' => 'my published subject',
            'published_at' => '2022-10-19 11:09:00',
        ]);

        $this->get('notifications/newsletter')->assertRedirect();

        $this->beUser();
        $this->get('notifications/newsletter')
            ->assertSuccessful()
            ->assertSee('my published subject')
            ->assertDontSee('my unpublished subject');
    }
}
