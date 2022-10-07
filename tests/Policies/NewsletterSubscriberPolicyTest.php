<?php

namespace Biigle\Tests\Modules\Newsletter\Policies;

use ApiTestCase;
use Biigle\Modules\Newsletter\NewsletterSubscriber;
use Biigle\Role;

class NewsletterSubscriberPolicyTest extends ApiTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->subscriber = NewsletterSubscriber::factory()->create();
    }

    public function testDestroy()
    {
        $this->assertFalse($this->globalGuest()->can('destroy', $this->subscriber));
        $this->assertFalse($this->user()->can('destroy', $this->subscriber));
        $this->assertFalse($this->guest()->can('destroy', $this->subscriber));
        $this->assertFalse($this->editor()->can('destroy', $this->subscriber));
        $this->assertFalse($this->expert()->can('destroy', $this->subscriber));
        $this->assertFalse($this->admin()->can('destroy', $this->subscriber));
        $this->assertTrue($this->globalAdmin()->can('destroy', $this->subscriber));
    }
}
