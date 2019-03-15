<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class CompaniesStoreRequest extends FormRequest
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
            'name' => 'required',
            'tax_number' => 'required|integer',
            'city' => 'required',
            'billing_address' => 'required',
            'country' => 'required',
            'postal_code' => 'required',
            'employees_size' => 'required|integer',
            'fax' => 'required',
            'description' => 'required',
            'phone' => 'required',
            'client_id' => 'required',
        ];
    }
}
