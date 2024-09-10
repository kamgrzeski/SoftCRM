<?php

namespace App\Queries;

use App\Models\ProductsModel;
use App\Models\SettingsModel;

/**
 * Class ProductsQueries
 *
 * Query class for handling operations related to the ProductsModel.
 */
class ProductsQueries
{
    /**
     * Get the count of all products.
     *
     * @return int
     */
    public static function countAll()
    {
        return ProductsModel::count();
    }

    /**
     * Get all products ordered by creation date in descending order.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getProductsByCreatedAt(): \Illuminate\Database\Eloquent\Collection
    {
        return ProductsModel::orderBy('created_at', 'desc')->get();
    }

    /**
     * Get paginated list of products.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public static function getPaginate(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return ProductsModel::orderByDesc('id')
            ->paginate(SettingsModel::where('key', 'pagination_size')
                ->get()->last()->value);
    }

    /**
     * Get all products.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return ProductsModel::all();
    }
}
