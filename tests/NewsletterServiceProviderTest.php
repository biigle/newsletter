<?php

namespace Biigle\Tests\Modules\Newsletter;

use Biigle\Modules\Newsletter\NewsletterServiceProvider;
use TestCase;

class NewsletterServiceProviderTest extends TestCase
{
    public function testServiceProvider()
    {
        $this->assertTrue(class_exists(NewsletterServiceProvider::class));
    }
}
