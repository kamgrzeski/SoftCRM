<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class SettingsStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
//        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'pagination_size' => 'integer',
            'currency' => 'string',
            'priority_size' => 'integer',
            'invoice_tax' => 'integer',
            'rollbar_token' => '',
            'loading_circle' => '',
            'stats' => ''
        ];
    }
}
