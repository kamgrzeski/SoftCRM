<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    /**
     * @param $allInputs
     * @return mixed
     */
    public static function insertRow($allInputs)
    {
        return Companies::insert(
            [
                'name' => $allInputs['name'],
                'tax_number' => $allInputs['tax_number'],
                'phone' => $allInputs['phone'],
                'city' => $allInputs['city'],
                'billing_address' => $allInputs['billing_address'],
                'country' => $allInputs['country'],
                'postal_code' => $allInputs['postal_code'],
                'employees' => $allInputs['employees'],
                'fax' => $allInputs['fax'],
                'description' => $allInputs['description'],
                'client_id' => $allInputs['client_id'],
                'is_active' => 1
            ]
        );
    }

    /**
     * @param $id
     * @param $allInputs
     * @return mixed
     */
    public static function updateRow($id, $allInputs)
    {
        return Companies::where('id', '=', $id)->update(
            [
                'name' => $allInputs['name'],
                'tax_number' => $allInputs['tax_number'],
                'phone' => $allInputs['phone'],
                'city' => $allInputs['city'],
                'billing_address' => $allInputs['billing_address'],
                'country' => $allInputs['country'],
                'postal_code' => $allInputs['postal_code'],
                'employees' => $allInputs['employees'],
                'fax' => $allInputs['fax'],
                'description' => $allInputs['description'],
                'client_id' => $allInputs['client_id'],
                'is_active' => 1
            ]);
    }

    /**
     * @param $rulesType
     * @return array
     */
    public static function getRules($rulesType)
    {
        switch ($rulesType) {
            case 'STORE':
                return [
                    'name' => 'required',
                    'tax_number' => 'required|unique:companies|integer',
                    'city' => 'required',
                    'billing_address' => 'required',
                    'country' => 'required',
                    'postal_code' => 'required',
                    'employees' => 'required|integer',
                    'fax' => 'required',
                    'description' => 'required',
                    'phone' => 'required|integer',
                    'client_id' => 'required',
                ];
        }
    }

    /**
     * @param $id
     * @param $activeType
     * @return bool
     */
    public static function setActive($id, $activeType)
    {
        $query = Companies::where('id', '=', $id)->update(
            [
                'is_active' => $activeType
            ]);

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @return int
     */
    public static function countCompanies()
    {
        return count(Companies::get());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deals()
    {
        return $this->belongsTo(Deals::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function employees()
    {
        return $this->hasMany(Employees::class);

    }
}
