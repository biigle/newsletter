<?php

namespace Biigle\Modules\Newsletter\Http\Controllers\Api;

use Biigle\Http\Controllers\Api\Controller;
use Biigle\Modules\Newsletter\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterSubscriberController extends Controller
{
    /**
     * Delete a newsletter subscriber.
     *
     * @api {delete} newsletter-subscribers/:id Selete a newsletter subscriber
     * @apiGroup Newsletter
     * @apiName DestroyNewsletterSubscriber
     * @apiPermission admin
     *
     * @apiParam {Number} id The newsletter subscriber ID.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subscriber = NewsletterSubscriber::findOrFail($id);
        $this->authorize('destroy', $subscriber);
        $subscriber->delete();
    }
}
