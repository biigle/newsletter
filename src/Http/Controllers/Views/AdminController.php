<?php

namespace Biigle\Modules\Newsletter\Http\Controllers\Views;

use Biigle\Http\Controllers\Views\Controller;
use Biigle\Modules\Newsletter\Newsletter;
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

        $draft = Newsletter::draft()->first();

        return view('newsletter::admin.index', [
            'subscribers' => $subscribers,
            'query' => $request->get('q'),
            'draft' => $draft,
        ]);
    }

    /**
     * Shows the create newsletter view.
     *
     * @return mixed
     */
    public function create()
    {
        $n = Newsletter::draft()->first();

        if (is_null($n)) {
            return view('newsletter::admin.create');
        }

        return redirect()->route('newsletter.admin.edit', $n->id);
    }

    /**
     * Shows the edit newsletter view.
     *
     * @@param int $id
     * @return mixed
     */
    public function edit($id)
    {
        $n = Newsletter::findOrFail($id);

        return view('newsletter::admin.edit', [
            'newsletter' => $n,
            'readOnly' => !is_null($n->published_at),
        ]);
    }
}
