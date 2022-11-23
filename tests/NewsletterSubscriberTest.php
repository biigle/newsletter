<?php

namespace Biigle\Tests\Modules\Newsletter;

use Biigle\Modules\Newsletter\NewsletterSubscriber;
use ModelTestCase;

class NewsletterSubscriberTest extends ModelTestCase
{
    protected static $modelClass = NewsletterSubscriber::class;

    public function testAttributes()
    {
        $this->assertNotNull($this->model->email);
        $this->assertNotNull($this->model->created_at);
        $this->assertNotNull($this->model->updated_at);
        $this->assertNull($this->model->email_verified_at);
    }

    public function testVerifiedScope()
    {
        $this->assertEquals(0, NewsletterSubscriber::verified()->count());
        $this->model->email_verified_at = now();
        $this->model->save();
        $this->assertEquals(1, NewsletterSubscriber::verified()->count());
    }
}
