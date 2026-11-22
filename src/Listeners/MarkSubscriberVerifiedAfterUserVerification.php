<?php

namespace Biigle\Modules\Newsletter\Listeners;

use Biigle\Modules\Newsletter\NewsletterSubscriber;
use Biigle\User;
use Illuminate\Auth\Events\Verified;

class MarkSubscriberVerifiedAfterUserVerification
{
    public function handle(Verified $event): void
    {
        if (!config('biigle.email_verification') || config('biigle.offline_mode')) {
            return;
        }

        $user = $event->user;
        if (!$user instanceof User) {
            return;
        }

        $subscriber = NewsletterSubscriber::where('email', $user->email)->first();
        if ($subscriber && !$subscriber->hasVerifiedEmail()) {
            $subscriber->markEmailAsVerified();
        }
    }
}
