<?php

namespace Biigle\Modules\Newsletter\Http\Controllers\Views;

use Biigle\Http\Controllers\Views\Controller;
use Biigle\Modules\Newsletter\NewsletterSubscriber;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    /**
     * Shows the list of subscribers page.
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $subscribers = NewsletterSubscriber::verified()
            ->select('id', 'email', 'created_at')
            ->when($request->has('q'), function ($query) use ($request) {
                $q = $request->get('q');
                $query->where(function ($query) use ($q) {
                    $query->where('email', 'ilike', "%$q%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(100);

        return view('newsletter::admin.index', [
            'subscribers' => $subscribers,
            'query' => $request->get('q'),
        ]);
    }
}
