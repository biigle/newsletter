<?php

namespace Biigle\Tests\Modules\Newsletter;

use Biigle\Modules\Newsletter\Newsletter;
use ModelTestCase;

class NewsletterTest extends ModelTestCase
{
    protected static $modelClass = Newsletter::class;

    public function testAttributes()
    {
        $this->assertNotNull($this->model->subject);
        $this->assertNotNull($this->model->body);
        $this->assertNotNull($this->model->created_at);
        $this->assertNotNull($this->model->updated_at);
        $this->assertNull($this->model->published_at);
    }
}