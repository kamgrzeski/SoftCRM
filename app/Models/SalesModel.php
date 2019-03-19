<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Config;

class SalesModel extends Model
{
    protected $table = 'sales';

    public function products()
    {
        return $this->belongsTo(ProductsModel::class, 'product_id');
    }

    public function storeTask($requestedData)
    {
        return self::insertGetId(
            [
                'name' => $requestedData['name'],
                'quantity' => $requestedData['quantity'],
                'date_of_payment' => $requestedData['date_of_payment'],
                'product_id' => $requestedData['product_id'],
                'created_at' => Carbon::now(),
                'is_active' => 1,
                'price' => 0
            ]
        );
    }

    public function updateTask($saleId, $requestedData)
    {
        return self::where('id', '=', $saleId)->update(
            [
                'name' => $requestedData['name'],
                'quantity' => $requestedData['quantity'],
                'date_of_payment' => $requestedData['date_of_payment'],
                'product_id' => $requestedData['product_id'],
                'updated_at' => Carbon::now(),
                'is_active' => 1
            ]);
    }

    public function setActive($saleId, $activeType)
    {
        $findSalesById = self::where('id', '=', $saleId)->update(
            [
                'is_active' => $activeType
            ]);

        if ($findSalesById) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function countSales()
    {
        return self::all()->count();
    }

    public function getPaginate()
    {
        return self::paginate(Config::get('crm_settings.pagination_size'));
    }

    public function getSalesSortedByCreatedAt()
    {
        return self::all()->sortByDesc('created_at');
    }
}
