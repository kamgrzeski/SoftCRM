<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sales extends Model
{
    /**
     * @param $allInputs
     * @return mixed
     */
    public static function insertRow($allInputs)
    {
        return Sales::insert(
            [
                'name' => $allInputs['name'],
                'created_at' => Carbon::now(),
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
        return Sales::where('id', '=', $id)->update(
            [
                'name' => $allInputs['name'],
                'updated_at' => Carbon::now(),
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
                    'name' => 'required'
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
        $findSalesById = Sales::where('id', '=', $id)->update(
            [
                'is_active' => $activeType
            ]);

        if ($findSalesById) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @return int
     */
    public static function countSales()
    {
        return count(Sales::get());
    }

    /**
     * @param $type
     * @param $value
     * @param int $paginationLimit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function trySearchSalesByValue($type, $value, $paginationLimit = 10)
    {
        return Sales::where($type, 'LIKE', '%' . $value . '%')->paginate($paginationLimit);
    }
}
