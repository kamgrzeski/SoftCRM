<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ProductsModel extends Model
{
    protected $table = 'products';

    public function sales()
    {
        return $this->hasMany(SalesModel::class);
    }

    public function insertRow($allInputs)
    {
        return self::insertGetId(
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

    public function updateRow($id, $allInputs)
    {
        return self::where('id', '=', $id)->update(
            [
                'name' => $allInputs['name'],
                'category' => $allInputs['category'],
                'count' => $allInputs['count'],
                'price' => $allInputs['price'],
                'updated_at' => Carbon::now(),
                'is_active' => 1
            ]);
    }

    public function setActive($id, $activeType)
    {
        $findProductsById = self::where('id', '=', $id)->update(
            [
                'is_active' => $activeType
            ]);

        if ($findProductsById) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public static function countProducts()
    {
        return self::get()->count();
    }

    public function trySearchProductsByValue($type, $value, $paginationLimit = 10)
    {
        return self::where($type, 'LIKE', '%' . $value . '%')->paginate($paginationLimit);
    }

    public function getProductsByCreatedAt()
    {
        return self::all()->sortBy('created_at', 0, true)->slice(0, 5);
    }
}
