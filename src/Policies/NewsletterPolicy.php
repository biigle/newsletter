<?php

namespace Biigle\Modules\Newsletter\Policies;

use Biigle\Modules\Newsletter\Newsletter;
use Biigle\Policies\CachedPolicy;
use Biigle\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NewsletterPolicy extends CachedPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given user can create a newsletter.
     *
     * @param User $user
     *
     * @return bool
     */
    public function create(User $user)
    {
        return $user->can('sudo');
    }
}
