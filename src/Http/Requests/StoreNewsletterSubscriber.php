<?php

namespace Biigle\Modules\Newsletter\Http\Requests;

use Biigle\Rules\Uuid4;
use Biigle\User;
use Illuminate\Foundation\Http\FormRequest;
use View;

class StoreNewsletterSubscriber extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'email' => 'required|string|email|max:256',
            'website' => 'honeypot',
            'homepage' => 'honeytime:5|required',
        ];

        if (View::exists('privacy')) {
            $rules['privacy'] = 'required|accepted';
        }

        return $rules;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge(['email' => strtolower($this->input('email'))]);
    }
}
