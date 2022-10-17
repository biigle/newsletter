<?php

namespace Biigle\Modules\Newsletter\Http\Controllers\Api;

use Biigle\Http\Controllers\Api\Controller;
use Biigle\Modules\Newsletter\Http\Requests\StoreNewsletter;
use Biigle\Modules\Newsletter\Http\Requests\UpdateNewsletter;
use Biigle\Modules\Newsletter\Newsletter;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    /**
     * Create a new newsletter draft
     *
     * @api {post} newsletters Create a new newsletter draft
     * @apiParam {String} subject The subject of the newsletter.
     * @apiParam {String} body The body of the newsletter.
     * @apiGroup Newsletter
     * @apiName StoreNewsletter
     * @apiPermission admin
     *
     * @param StoreNewsletter $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNewsletter $request)
    {
        $n = Newsletter::create($request->validated());

        if (!$this->isAutomatedRequest()) {
            return $this->fuzzyRedirect()
                ->with('message', 'New newsletter draft created.')
                ->with('messageType', 'success');;
        }

        return $n;
    }

    /**
     * Update a newsletter draft
     *
     * @api {put} newsletters/:id Update a newsletter draft
     * @apiParam {String} subject The subject of the newsletter.
     * @apiParam {String} body The body of the newsletter.
     * @apiGroup Newsletter
     * @apiName UpdateNewsletter
     * @apiPermission admin
     *
     * @param UpdateNewsletter $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNewsletter $request)
    {
        $request->newsletter->update($request->validated());

        if (!$this->isAutomatedRequest()) {
            return $this->fuzzyRedirect();
        }
    }
}
