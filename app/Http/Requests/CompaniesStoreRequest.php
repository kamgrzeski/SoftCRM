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
            'name' => 'required|string',
            'tax_number' => 'required|integer',
            'city' => 'required|string',
            'billing_address' => 'required|string',
            'country' => 'required|string',
            'postal_code' => 'required|string',
            'employees_size' => 'required|integer',
            'fax' => 'required|string',
            'description' => 'required|string',
            'phone' => 'required|string',
            'client_id' => 'required|integer',
        ];
    }
}
