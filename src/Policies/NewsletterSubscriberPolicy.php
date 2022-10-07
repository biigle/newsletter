<?php

namespace Biigle\Modules\Newsletter\Policies;

use Biigle\Modules\Newsletter\NewsletterSubscriber;
use Biigle\Policies\CachedPolicy;
use Biigle\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NewsletterSubscriberPolicy extends CachedPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given user can destroy the subscriber.
     *
     * @param User $user
     * @param NewsletterSubscriber $subscriber
     *
     * @return bool
     */
    public function destroy(User $user, NewsletterSubscriber $subscriber)
    {
        return $user->can('sudo');
    }
}
