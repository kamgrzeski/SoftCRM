<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SalesModel extends Model
{
    protected $table = 'sales';

    public function insertRow($allInputs)
    {
        return SalesModel::insertGetId(
            [
                'name' => $allInputs['name'],
                'quantity' => $allInputs['quantity'],
                'date_of_payment' => $allInputs['date_of_payment'],
                'product_id' => $allInputs['product_id'],
                'created_at' => Carbon::now(),
                'is_active' => 1
            ]
        );
    }

    public function updateRow($id, $allInputs)
    {
        return SalesModel::where('id', '=', $id)->update(
            [
                'name' => $allInputs['name'],
                'quantity' => $allInputs['quantity'],
                'date_of_payment' => $allInputs['date_of_payment'],
                'product_id' => $allInputs['product_id'],
                'updated_at' => Carbon::now(),
                'is_active' => 1
            ]);
    }

    public function setActive($id, $activeType)
    {
        $findSalesById = SalesModel::where('id', '=', $id)->update(
            [
                'is_active' => $activeType
            ]);

        if ($findSalesById) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public static function countSales()
    {
        return SalesModel::all()->count();
    }

    public function products()
    {
        return $this->belongsTo(ProductsModel::class, 'product_id');
    }

    public static function trySearchSalesByValue($type, $value, $paginationLimit = 10)
    {
        return SalesModel::where($type, 'LIKE', '%' . $value . '%')->paginate($paginationLimit);
    }
}
