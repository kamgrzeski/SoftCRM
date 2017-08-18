<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Deals extends Model
{
    /**
     * @param $allInputs
     * @return mixed
     */
    public static function insertRow($allInputs)
    {
        return DB::table('deals')->insert(
            [
                'name' => $allInputs['name'],
                'start_time' => $allInputs['start_time'],
                'end_time' => $allInputs['end_time'],
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
        return DB::table('deals')
            ->where('id', '=', $id)
            ->update([
                'name' => $allInputs['name'],
                'start_time' => $allInputs['start_time'],
                'end_time' => $allInputs['end_time'],
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
                    'start_time' => 'required',
                    'end_time' => 'required',
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
        $query = DB::table('deals')
            ->where('id', '=', $id)
            ->update([
                'is_active' => $activeType
            ]);

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
