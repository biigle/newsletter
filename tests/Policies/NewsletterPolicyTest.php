<?php

namespace Biigle\Tests\Modules\Newsletter\Policies;

use ApiTestCase;
use Biigle\Modules\Newsletter\Newsletter;
use Biigle\Role;

class NewsletterPolicyTest extends ApiTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->newsletter = Newsletter::factory()->create();
    }

    public function testCreate()
    {
        $this->assertFalse($this->globalGuest()->can('create', Newsletter::class));
        $this->assertFalse($this->user()->can('create', Newsletter::class));
        $this->assertFalse($this->guest()->can('create', Newsletter::class));
        $this->assertFalse($this->editor()->can('create', Newsletter::class));
        $this->assertFalse($this->expert()->can('create', Newsletter::class));
        $this->assertFalse($this->admin()->can('create', Newsletter::class));
        $this->assertTrue($this->globalAdmin()->can('create', Newsletter::class));
    }

    public function testUpdate()
    {
        $this->assertFalse($this->globalGuest()->can('create', $this->newsletter));
        $this->assertFalse($this->user()->can('create', $this->newsletter));
        $this->assertFalse($this->guest()->can('create', $this->newsletter));
        $this->assertFalse($this->editor()->can('create', $this->newsletter));
        $this->assertFalse($this->expert()->can('create', $this->newsletter));
        $this->assertFalse($this->admin()->can('create', $this->newsletter));
        $this->assertTrue($this->globalAdmin()->can('create', $this->newsletter));
    }
}
