<?php

namespace Biigle\Modules\Newsletter\Http\Controllers;

use Biigle\Http\Controllers\Views\Controller;
use Biigle\Modules\Newsletter\Http\Requests\StoreNewsletterSubscriber;
use Biigle\Modules\Newsletter\NewsletterSubscriber;

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
        // We dpn't want to throw an error if an email address is added again because
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
}
