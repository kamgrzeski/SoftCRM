<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    /**
     * @param $allInputs
     * @return mixed
     */
    public static function insertRow($allInputs)
    {
        return Products::insert(
            [
                'name' => $allInputs['name'],
                'category' => $allInputs['category'],
                'count' => $allInputs['count'],
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
        return Products::where('id', '=', $id)->update(
            [
                'name' => $allInputs['name'],
                'companies_id' => $allInputs['companies_id'],
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
                    'companies_id' => 'required',
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
        $findProductsById = Products::where('id', '=', $id)->update(
            [
                'is_active' => $activeType
            ]);

        if ($findProductsById) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @return int
     */
    public static function countProducts()
    {
        return count(Products::get());
    }

    /**
     * @param $type
     * @param $value
     * @param int $paginationLimit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function trySearchProductsByValue($type, $value, $paginationLimit = 10)
    {
        return Products::where($type, 'LIKE', '%' . $value . '%')->paginate($paginationLimit);
    }
}
