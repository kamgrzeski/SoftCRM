<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Config;

class ProductsModel extends Model
{
    protected $table = 'products';

    public function sales()
    {
        return $this->hasMany(SalesModel::class, 'id');
    }

    public function storeProduct(array $requestedData, int $adminId) : int
    {
        return self::insertGetId(
            [
                'name' => $requestedData['name'],
                'category' => $requestedData['category'],
                'count' => $requestedData['count'],
                'price' => $requestedData['price'] * 100,
                'created_at' => Carbon::now(),
                'is_active' => 1,
                'admin_id' => $adminId
            ]
        );
    }

    public function updateProduct(int $productId, array $requestedData) : bool
    {
        return self::where('id', '=', $productId)->update(
            [
                'name' => $requestedData['name'],
                'category' => $requestedData['category'],
                'count' => $requestedData['count'],
                'price' => $requestedData['price'],
                'updated_at' => Carbon::now(),
                'is_active' => 1
            ]);
    }

    public function setActive(int $productId, int $activeType) : bool
    {
        $findProductsById = self::where('id', '=', $productId)->update(
            [
                'is_active' => $activeType
            ]);

        if ($findProductsById) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function countProducts() : int
    {
        return self::get()->count();
    }

    public function getProductsByCreatedAt()
    {
        return self::all()->sortBy('created_at', 0, true)->slice(0, 5);
    }

    public function findClientByGivenClientId(int $productId)
    {
        $query = self::find($productId);

        Arr::add($query, 'salesCount', count($query->sales));

        return $query;
    }

    public function getProducts()
    {
        return self::all()->sortByDesc('created_at');
    }

    public function getPaginate()
    {
        return self::paginate(Config::get('crm_settings.pagination_size'));
    }

    public function getProduct(int $productId) : self
    {
        return self::find($productId);
    }
}
