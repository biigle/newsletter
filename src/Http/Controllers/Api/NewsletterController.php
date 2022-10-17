<?php

namespace Biigle\Modules\Newsletter\Http\Controllers\Api;

use Biigle\Http\Controllers\Api\Controller;
use Biigle\Modules\Newsletter\Http\Requests\StoreNewsletter;
use Biigle\Modules\Newsletter\Newsletter;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    /**
     * Create a new newsletter draft
     *
     * @api {post} newsletters Create a new newsletter draft
     * @apiGroup Newsletter
     * @apiName StoreNewsletter
     * @apiPermission admin
     *
     * @param StoreNewsletter $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNewsletter $request)
    {
        return Newsletter::create($request->validated());
    }
}
