<?php

namespace Biigle\Tests\Modules\Newsletter\Policies;

use ApiTestCase;
use Biigle\Modules\Newsletter\Newsletter;
use Biigle\Role;
use Gate;

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

    public function testAccess()
    {
        $this->assertFalse(Gate::allows('access', $this->newsletter));
        $this->assertFalse($this->globalGuest()->can('access', $this->newsletter));
        $this->assertFalse($this->user()->can('access', $this->newsletter));
        $this->assertFalse($this->guest()->can('access', $this->newsletter));
        $this->assertFalse($this->editor()->can('access', $this->newsletter));
        $this->assertFalse($this->expert()->can('access', $this->newsletter));
        $this->assertFalse($this->admin()->can('access', $this->newsletter));
        $this->assertTrue($this->globalAdmin()->can('access', $this->newsletter));
    }

    public function testAccessPublished()
    {
        $this->newsletter->published_at = '2022-10-17 16:47';
        $this->assertTrue(Gate::allows('access', $this->newsletter));
        $this->assertTrue($this->globalGuest()->can('access', $this->newsletter));
        $this->assertTrue($this->user()->can('access', $this->newsletter));
        $this->assertTrue($this->guest()->can('access', $this->newsletter));
        $this->assertTrue($this->editor()->can('access', $this->newsletter));
        $this->assertTrue($this->expert()->can('access', $this->newsletter));
        $this->assertTrue($this->admin()->can('access', $this->newsletter));
        $this->assertTrue($this->globalAdmin()->can('access', $this->newsletter));
    }


    public function testUpdate()
    {
        $this->assertFalse($this->globalGuest()->can('update', $this->newsletter));
        $this->assertFalse($this->user()->can('update', $this->newsletter));
        $this->assertFalse($this->guest()->can('update', $this->newsletter));
        $this->assertFalse($this->editor()->can('update', $this->newsletter));
        $this->assertFalse($this->expert()->can('update', $this->newsletter));
        $this->assertFalse($this->admin()->can('update', $this->newsletter));
        $this->assertTrue($this->globalAdmin()->can('update', $this->newsletter));
    }

    public function testPublish()
    {
        $this->assertFalse($this->globalGuest()->can('publish', $this->newsletter));
        $this->assertFalse($this->user()->can('publish', $this->newsletter));
        $this->assertFalse($this->guest()->can('publish', $this->newsletter));
        $this->assertFalse($this->editor()->can('publish', $this->newsletter));
        $this->assertFalse($this->expert()->can('publish', $this->newsletter));
        $this->assertFalse($this->admin()->can('publish', $this->newsletter));
        $this->assertTrue($this->globalAdmin()->can('publish', $this->newsletter));
    }

    public function testDestroy()
    {
        $this->assertFalse($this->globalGuest()->can('destroy', $this->newsletter));
        $this->assertFalse($this->user()->can('destroy', $this->newsletter));
        $this->assertFalse($this->guest()->can('destroy', $this->newsletter));
        $this->assertFalse($this->editor()->can('destroy', $this->newsletter));
        $this->assertFalse($this->expert()->can('destroy', $this->newsletter));
        $this->assertFalse($this->admin()->can('destroy', $this->newsletter));
        $this->assertTrue($this->globalAdmin()->can('destroy', $this->newsletter));
    }
}
