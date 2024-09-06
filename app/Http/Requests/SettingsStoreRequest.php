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
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'pagination_size' => 'required|integer',
            'currency' => 'required|string',
            'priority_size' => 'required|integer',
            'invoice_tax' => 'required|integer',
            'loading_circle' => 'required'
        ];
    }
}
