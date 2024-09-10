<?php

namespace App\Queries;

use App\Models\SalesModel;
use App\Models\SettingsModel;

/**
 * Class SalesQueries
 *
 * Query class for handling operations related to the SalesModel.
 */
class SalesQueries
{
    /**
     * Get the count of all sales.
     *
     * @return int
     */
    public static function countAll(): int
    {
        return SalesModel::count();
    }

    /**
     * Get all sales sorted by creation date.
     *
     * @return \Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Collection
     */
    public static function getSalesSortedByCreatedAt(): \Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Collection
    {
        return SalesModel::all()->sortBy('created_at');
    }

    /**
     * Get paginated list of sales.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public static function getPaginate(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return SalesModel::orderByDesc('id')
            ->paginate(SettingsModel::where('key', 'pagination_size')
                ->get()->last()->value);
    }
}
