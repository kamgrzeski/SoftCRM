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
                    'name'       => 'required',
                    'tags'       => 'required',
                    'tax_number'       => 'required',
                ];
        }
    }
}
