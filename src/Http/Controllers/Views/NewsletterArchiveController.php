<?php

namespace Biigle\Modules\Newsletter\Http\Controllers\Views;

use Biigle\Http\Controllers\Views\Controller;
use Biigle\Modules\Newsletter\Newsletter;

class NewsletterArchiveController extends Controller
{

    /**
     * Shows the sign up page.
     *
     * @return mixed
     */
    public function index()
    {
        $newsletters = Newsletter::published()
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        return view('newsletter::notifications', [
            'newsletters' => $newsletters,
        ]);
    }
}
