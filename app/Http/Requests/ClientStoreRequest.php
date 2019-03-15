<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class ClientStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'full_name' => 'required|string',
            'phone' => 'required',
            'budget' => 'required',
            'section' => 'required',
            'email' => 'required|email',
            'location' => 'required',
            'zip' => 'required',
            'city' => 'required',
            'country' => 'required'
        ];
    }
}
