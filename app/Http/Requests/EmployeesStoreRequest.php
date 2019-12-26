<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class EmployeesStoreRequest extends FormRequest
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
            'phone' => 'required|string',
            'email' => 'required|email',
            'job' => 'required|string',
            'note' => 'required|string',
            'client_id' => 'required|integer'
        ];
    }
}
