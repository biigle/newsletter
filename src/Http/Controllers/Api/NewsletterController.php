<?php

namespace Biigle\Modules\Newsletter\Http\Controllers\Api;

use Biigle\Http\Controllers\Api\Controller;
use Biigle\Modules\Newsletter\Http\Requests\StoreNewsletter;
use Biigle\Modules\Newsletter\Http\Requests\UpdateNewsletter;
use Biigle\Modules\Newsletter\Newsletter;
use Biigle\Modules\Newsletter\NewsletterSubscriber;
use Biigle\Modules\Newsletter\Notifications\NewNewsletter;
use Illuminate\Http\Request;
use Notification;

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
            return $this->fuzzyRedirect('newsletter.admin.edit', $n->id)
                ->with('message', 'New newsletter draft created.')
                ->with('messageType', 'success');
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

    /**
     * Publish a newsletter
     *
     * @api {post} newsletters/:id/publish Publish a newsletter
     * @apiGroup Newsletter
     * @apiName PublishNewsletter
     * @apiPermission admin
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function publish($id)
    {
        $n = Newsletter::draft()->findOrFail($id);
        $this->authorize('publish', $n);
        $n->published_at = now();
        $n->save();

        $subscribers = NewsletterSubscriber::verified()->get();
        Notification::send($subscribers, new NewNewsletter($n));

        if (!$this->isAutomatedRequest()) {
            return $this->fuzzyRedirect()
                ->with('message', 'Newsletter published.')
                ->with('messageType', 'success');
        }
    }

    /**
     * Delete a newsletter draft
     *
     * @api {delete} newsletters/:id Delete a newsletter draft
     * @apiGroup Newsletter
     * @apiName DestroyNewsletter
     * @apiPermission admin
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $n = Newsletter::findOrFail($id);
        $this->authorize('destroy', $n);
        $n->delete();

        if (!$this->isAutomatedRequest()) {
            return $this->fuzzyRedirect('newsletter.admin.index')
                ->with('message', 'New newsletter draft discarded.')
                ->with('messageType', 'success');
        }
    }
}
