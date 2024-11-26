<?php

namespace App\Queries;

use App\Models\Deal;
use App\Models\Setting;

/**
 * Class DealsQueries
 *
 * Query class for handling operations related to the DealsModel.
 */
class DealQueries
{
    /**
     * Get all deals created in the latest month.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getDealsInLatestMonth(): \Illuminate\Database\Eloquent\Collection
    {
        return Deal::where('created_at', '>=', now()->subMonth())->get();
    }

    /**
     * Get the count of all deals.
     *
     * @return int
     */
    public static function countAll(): int
    {
        return Deal::all()->count();
    }

    /**
     * Get the count of all deactivated deals.
     *
     * @return int
     */
    public static function getDeactivated(): int
    {
        return Deal::where('is_active', '=', 0)->count();
    }

    /**
     * Get paginated list of deals.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public static function getPaginate(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return Deal::orderByDesc('id')
            ->paginate(Setting::where('key', 'pagination_size')
                ->get()->last()->value);
    }
}
