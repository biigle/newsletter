<?php

namespace Biigle\Modules\Newsletter\Http\Requests;

use Biigle\Modules\Newsletter\Newsletter;
use Illuminate\Foundation\Http\FormRequest;

class UpdateNewsletter extends FormRequest
{

    public Newsletter $newsletter;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->newsletter = Newsletter::findOrFail($this->route('id'));

        return $this->user()->can('update', $this->newsletter);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'subject' => 'required_without:body|string',
            'body' => 'required_without:subject|string',
        ];
    }
}
