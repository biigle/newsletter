<?php

namespace Biigle\Modules\Newsletter\Http\Controllers\Mixins;

use Biigle\User;
use Biigle\Modules\Newsletter\NewsletterSubscriber;

class RegisterControllerMixin
{
    /**
     * Handle a newly created user.
     *
     * @param User $user
     * @param array $data
     */
    public function create(User $user, array $data)
    {
        if (array_key_exists('newsletter', $data) && $data['newsletter']) {
            $s = NewsletterSubscriber::firstOrCreate([
                'email' => $user->email,
            ]);

            if ($s->wasRecentlyCreated) {
                $s->sendEmailVerificationNotification();
            }
        }
    }
}
