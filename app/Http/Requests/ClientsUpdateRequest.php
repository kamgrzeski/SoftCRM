<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientsUpdateRequest extends FormRequest
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
            'full_name' => 'string',
            'phone' => 'string',
            'budget' => 'integer',
            'section' => 'string',
            'email' => 'email',
            'location' => 'string',
            'zip' => 'string',
            'city' => 'string',
            'country' => 'string'
        ];
    }
}
