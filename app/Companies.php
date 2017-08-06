<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Companies extends Model
{

    /**
     * @param $allInputs
     * @return mixed
     */
    public static function insertRow($allInputs)
    {
        return DB::table('companies')->insert(
            [
                'name' => $allInputs['name'],
                'tax_number' => $allInputs['tax_number'],
                'tags' => $allInputs['tags'],
                'city' => $allInputs['city'],
                'billing_address' => $allInputs['billing_address'],
                'state' => $allInputs['state'],
                'country' => $allInputs['country'],
                'postal_code' => $allInputs['postal_code'],
                'employees' => $allInputs['employees'],
                'fax' => $allInputs['fax'],
                'description' => $allInputs['description'],
                'is_active' => 1
            ]
        );
    }

    public static function updateRow($id, $allInputs)
    {
        return DB::table('companies')
            ->where('id', '=', $id)
            ->update([
                'name' => $allInputs['name'],
                'tax_number' => $allInputs['tax_number'],
                'tags' => $allInputs['tags'],
                'city' => $allInputs['city'],
                'billing_address' => $allInputs['billing_address'],
                'state' => $allInputs['state'],
                'country' => $allInputs['country'],
                'postal_code' => $allInputs['postal_code'],
                'employees' => $allInputs['employees'],
                'fax' => $allInputs['fax'],
                'description' => $allInputs['description'],
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
                    'tax_number' => 'required|unique:companies',
                    'tags' => 'required',
                    'city' => 'required',
                    'billing_address' => 'required',
                    'state' => 'required',
                    'country' => 'required',
                    'postal_code' => 'required',
                    'employees' => 'required',
                    'fax' => 'required',
                    'description' => 'required',
                    'tags' => 'required',
                ];
        }
    }

    public static function setActive($id, $activeType) {
         $query = DB::table('companies')
             ->where('id', '=', $id)
             ->update([
                 'is_active' => $activeType
             ]);

         if($query) {
             return TRUE;
         } else {
             return FALSE;
         }
    }
}
