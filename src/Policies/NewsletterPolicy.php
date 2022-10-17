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

    /**
     * Determine if the given user can update a newsletter.
     *
     * @param User $user
     * @param Newsletter $n
     *
     * @return bool
     */
    public function update(User $user, Newsletter $n)
    {
        return $user->can('sudo');
    }
}
