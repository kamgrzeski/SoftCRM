<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Config;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesModel extends Model
{
    use SoftDeletes;

    protected $table = 'sales';
    protected $dates = ['deleted_at'];

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
                'created_at' => now(),
                'is_active' => true,
                'admin_id' => $adminId
            ]
        );
    }

    public function updateSale(int $saleId, array $requestedData) : int
    {
        return $this->where('id', '=', $saleId)->update(
            [
                'name' => $requestedData['name'],
                'quantity' => $requestedData['quantity'],
                'date_of_payment' => $requestedData['date_of_payment'],
                'product_id' => $requestedData['product_id'],
                'price' => $requestedData['price'],
                'updated_at' => now()
            ]
        );
    }

    public function setActive(int $saleId, int $activeType) : int
    {
        return $this->where('id', '=', $saleId)->update(
            [
                'is_active' => $activeType,
                'updated_at' => now()
            ]
        );
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
        return $this->all()->sortBy('created_at');
    }

    public function getSale(int $saleId) : self
    {
        return $this->find($saleId);
    }
}
