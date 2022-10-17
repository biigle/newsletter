<?php

namespace Biigle\Tests\Modules\Newsletter\Http\Controllers\Views;

use Biigle\Modules\Newsletter\Newsletter;
use ApiTestCase;

class AdminControllerTest extends ApiTestCase
{
    public function testIndex()
    {
        $this->beUser();
        $this->get('admin/newsletter')->assertStatus(403);

        $this->beGlobalAdmin();
        $this->get('admin/newsletter')
            ->assertSuccessful()
            ->assertViewIs('newsletter::admin.index');
    }

    public function testCreate()
    {
        $this->beUser();
        $this->get('admin/newsletter/create')->assertStatus(403);

        $this->beGlobalAdmin();
        $this->get('admin/newsletter/create')
            ->assertSuccessful()
            ->assertViewIs('newsletter::admin.create');
    }

    public function testCreateWithDraft()
    {
        $n = Newsletter::factory()->create();

        $this->beGlobalAdmin();
        $this->get('admin/newsletter/create')
            ->assertRedirect("admin/newsletter/{$n->id}/edit");
    }

    public function testEdit()
    {
        $n = Newsletter::factory()->create();

        $this->beUser();
        $this->get("admin/newsletter/{$n->id}/edit")->assertStatus(403);

        $this->beGlobalAdmin();
        $this->get("admin/newsletter/{$n->id}/edit")
            ->assertSuccessful()
            ->assertViewIs('newsletter::admin.edit');
    }
}
