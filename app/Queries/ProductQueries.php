<?php

namespace App\Queries;

use App\Models\Product;
use App\Models\Setting;

/**
 * Class ProductsQueries
 *
 * Query class for handling operations related to the ProductsModel.
 */
class ProductQueries
{
    /**
     * Get the count of all products.
     *
     * @return int
     */
    public static function countAll()
    {
        return Product::count();
    }

    /**
     * Get all products ordered by creation date in descending order.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getProductsByCreatedAt(): \Illuminate\Database\Eloquent\Collection
    {
        return Product::orderBy('created_at', 'desc')->get();
    }

    /**
     * Get paginated list of products.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public static function getPaginate(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return Product::orderByDesc('id')
            ->paginate(Setting::where('key', 'pagination_size')
                ->get()->last()->value);
    }

    /**
     * Get all products.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return Product::all();
    }
}
