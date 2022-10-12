<?php

namespace Biigle\Tests\Modules\Newsletter\Http\Controllers\Views;

use Biigle\Modules\Newsletter\NewsletterSubscriber;
use Biigle\Modules\Newsletter\Notifications\VerifyEmail;
use Biigle\Modules\Newsletter\Notifications\Unsubscribed;
use Biigle\Tests\UserTest;
use Honeypot;
use Illuminate\Support\Facades\Notification;
use ApiTestCase;
use View;

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
}
