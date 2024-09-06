<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ClientUpdateRequest extends FormRequest
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
            'full_name' => 'required|string',
            'phone' => 'required|string',
            'budget' => 'required|integer',
            'section' => 'required|string',
            'email' => 'required|email',
            'location' => 'required|string',
            'zip' => 'required|string',
            'city' => 'required|string',
            'country' => 'required|string'
        ];
    }
}
