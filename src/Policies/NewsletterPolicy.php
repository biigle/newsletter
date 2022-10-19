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
     * Determine if the given user can access a newsletter.
     *
     * @param User $user
     * @param Newsletter $n
     *
     * @return bool
     */
    public function access(?User $user, Newsletter $n)
    {
        if (is_null($n->published_at)) {
            return $user && $user->can('sudo');
        }

        return true;
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
        if (!is_null($n->published_at)) {
            return $this->deny('Published newsletters cannot be updated.');
        }

        return $user->can('sudo');
    }

    /**
     * Determine if the given user can publish a newsletter.
     *
     * @param User $user
     * @param Newsletter $n
     *
     * @return bool
     */
    public function publish(User $user, Newsletter $n)
    {
        if (!is_null($n->published_at)) {
            return $this->deny('Published newsletters cannot be published.');
        }

        return $user->can('sudo');
    }

    /**
     * Determine if the given user can destroy a newsletter.
     *
     * @param User $user
     * @param Newsletter $n
     *
     * @return bool
     */
    public function destroy(User $user, Newsletter $n)
    {
        if (!is_null($n->published_at)) {
            return $this->deny('Published newsletters cannot be deleted.');
        }

        return $user->can('sudo');
    }
}
