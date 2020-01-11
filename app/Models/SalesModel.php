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

    public function storeSale(array $requestedData, int $adminId) : int
    {
        return $this->insertGetId(
            [
                'name' => $requestedData['name'],
                'quantity' => $requestedData['quantity'],
                'date_of_payment' => $requestedData['date_of_payment'],
                'product_id' => $requestedData['product_id'],
                'price' => $requestedData['price'],
                'created_at' => Carbon::now(),
                'is_active' => 1,
                'admin_id' => $adminId
            ]
        );
    }

    public function updateSale(int $saleId, array $requestedData) : bool
    {
        return $this->where('id', '=', $saleId)->update(
            [
                'name' => $requestedData['name'],
                'quantity' => $requestedData['quantity'],
                'date_of_payment' => $requestedData['date_of_payment'],
                'product_id' => $requestedData['product_id'],
                'price' => $requestedData['price'],
                'updated_at' => Carbon::now()
            ]);
    }

    public function setActive(int $saleId, int $activeType) : bool
    {
        return $this->where('id', '=', $saleId)->update(['is_active' => $activeType]);
    }

    public function countSales() : int
    {
        return $this->all()->count();
    }

    public function getPaginate()
    {
        return $this->paginate(Config::get('crm_settings.pagination_size'));
    }

    public function getSalesSortedByCreatedAt()
    {
        return $this->all()->sortByDesc('created_at');
    }

    public function getSale(int $saleId) : self
    {
        return $this->find($saleId);
    }
}
