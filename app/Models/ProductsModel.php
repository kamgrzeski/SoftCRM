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

    public function storeProduct($requestedData)
    {
        return self::insertGetId(
            [
                'name' => $requestedData['name'],
                'category' => $requestedData['category'],
                'count' => $requestedData['count'],
                'price' => $requestedData['price'] * 100,
                'created_at' => Carbon::now(),
                'is_active' => 1
            ]
        );
    }

    public function updateProduct($productId, $requestedData)
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

    public function setActive($productId, $activeType)
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

    public function countProducts()
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

    public function getProduct(int $productId)
    {
        return self::find($productId);
    }
}
