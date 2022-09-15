<?php

namespace Biigle\Modules\Newsletter\Http\Controllers;

use Biigle\Http\Controllers\Views\Controller;
use Biigle\Modules\Newsletter\Http\Requests\DestroyNewsletterSubscriber;
use Biigle\Modules\Newsletter\Http\Requests\EmailVerificationRequest;
use Biigle\Modules\Newsletter\Http\Requests\StoreNewsletterSubscriber;
use Biigle\Modules\Newsletter\NewsletterSubscriber;
use Biigle\Modules\Newsletter\Notifications\Unsubscribed;

class NewsletterController extends Controller
{

    /**
     * Shows the sign up page.
     *
     * @return mixed
     */
    public function index()
    {
        return view('newsletter::index');
    }

    /**
     * Creates a new newsletter subscriber
     *
     * @param StoreNewsletterSubscriber $request
     * @return \Illuminate\Http\Response
     */
    public function create(StoreNewsletterSubscriber $request)
    {
        // We don't want to throw an error if an email address is added again because
        // otherwise malicious actors could check which emails are already there.
        $s = NewsletterSubscriber::firstOrCreate([
            'email' => $request->input('email'),
        ]);

        if ($s->wasRecentlyCreated) {
            $s->sendEmailVerificationNotification();
        }

        if (!$this->isAutomatedRequest()) {
            return redirect('newsletter/verify');
        }
    }

    /**
     * Verify a subscription.
     *
     * @param EmailVerificationRequest $request
     * @return mixed
     */
    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect('newsletter/subscribed');
    }

    /**
     * Shows the created page.
     *
     * @return mixed
     */
    public function created()
    {
        return view('newsletter::created');
    }

    /**
     * Shows the subscribed page.
     *
     * @return mixed
     */
    public function subscribed()
    {
        return view('newsletter::subscribed');
    }

    /**
     * Shows the unsubscribe page.
     *
     * @return mixed
     */
    public function unsubscribe()
    {
        return view('newsletter::unsubscribe');
    }

    /**
     * Deletes a newsletter subscriber.
     *
     * @param DestroyNewsletterSubscriber $request
     * @return mixed
     */
    public function destroy(DestroyNewsletterSubscriber $request)
    {
        $s = NewsletterSubscriber::where('email', $request->input('email'))->first();

        if (!is_null($s)) {
            $s->delete();
            $s->notifyNow(new Unsubscribed);
        }

        return redirect('newsletter/unsubscribed');
    }

    /**
     * Shows the unsubscribed page.
     *
     * @return mixed
     */
    public function unsubscribed()
    {
        return view('newsletter::unsubscribed');
    }
}
