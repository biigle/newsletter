<?php

namespace Biigle\Tests\Modules\Module;

use Biigle\Modules\Module\NewsletterServiceProvider;
use TestCase;

class NewsletterServiceProviderTest extends TestCase
{
    public function testServiceProvider()
    {
        $this->assertTrue(class_exists(NewsletterServiceProvider::class));
    }
}
