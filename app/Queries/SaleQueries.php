<?php

namespace App\Queries;

use App\Models\Sale;
use App\Models\Setting;

/**
 * Class SalesQueries
 *
 * Query class for handling operations related to the SalesModel.
 */
class SaleQueries
{
    /**
     * Get the count of all sales.
     *
     * @return int
     */
    public static function countAll(): int
    {
        return Sale::count();
    }

    /**
     * Get all sales sorted by creation date.
     *
     * @return \Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Collection
     */
    public static function getSalesSortedByCreatedAt(): \Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Collection
    {
        return Sale::all()->sortBy('created_at');
    }

    /**
     * Get paginated list of sales.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public static function getPaginate(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return Sale::orderByDesc('id')
            ->paginate(Setting::where('key', 'pagination_size')
                ->get()->last()->value);
    }
}
