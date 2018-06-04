<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ProductsModel extends Model
{
    /**
     * table name
     */
    protected $table = 'products';

    /**
     * @param $allInputs
     * @return mixed
     */
    public function insertRow($allInputs)
    {
        return ProductsModel::insertGetId(
            [
                'name' => $allInputs['name'],
                'category' => $allInputs['category'],
                'count' => $allInputs['count'],
                'price' => $allInputs['price'] * 100,
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
    public function updateRow($id, $allInputs)
    {
        return ProductsModel::where('id', '=', $id)->update(
            [
                'name' => $allInputs['name'],
                'category' => $allInputs['category'],
                'count' => $allInputs['count'],
                'price' => $allInputs['price'],
                'updated_at' => Carbon::now(),
                'is_active' => 1
            ]);
    }

    /**
     * @param $rulesType
     * @return array
     */
    public function getRules($rulesType)
    {
        switch ($rulesType) {
            case 'STORE':
                return [
                    'name' => 'required',
                    'category' => 'required',
                    'count' => 'required',
                    'price' => 'required'
                ];
        }
    }

    /**
     * @param $id
     * @param $activeType
     * @return bool
     */
    public function setActive($id, $activeType)
    {
        $findProductsById = ProductsModel::where('id', '=', $id)->update(
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
        return count(ProductsModel::get());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sales()
    {
        return $this->hasMany(SalesModel::class);
    }

    /**
     * @param $type
     * @param $value
     * @param int $paginationLimit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function trySearchProductsByValue($type, $value, $paginationLimit = 10)
    {
        return ProductsModel::where($type, 'LIKE', '%' . $value . '%')->paginate($paginationLimit);
    }
}
