<?php

namespace Biigle\Modules\Newsletter\Http\Requests;

use Biigle\Modules\Newsletter\NewsletterSubscriber;
use Illuminate\Foundation\Auth\EmailVerificationRequest as Base;

class EmailVerificationRequest extends Base
{
    /**
     * Get the user resolver callback.
     *
     * @return \Closure
     */
    public function getUserResolver()
    {
        return fn() => NewsletterSubscriber::find($this->route('id'));
    }

    /**
     * Fulfill the email verification request.
     *
     * @return void
     */
    public function fulfill()
    {
        if (!$this->user()->hasVerifiedEmail()) {
            $this->user()->markEmailAsVerified();
        }
    }
}
