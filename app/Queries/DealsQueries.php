<?php

namespace App\Queries;

use App\Models\DealsModel;
use App\Models\SettingsModel;

/**
 * Class DealsQueries
 *
 * Query class for handling operations related to the DealsModel.
 */
class DealsQueries
{
    /**
     * Get all deals created in the latest month.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getDealsInLatestMonth(): \Illuminate\Database\Eloquent\Collection
    {
        return DealsModel::where('created_at', '>=', now()->subMonth())->get();
    }

    /**
     * Get the count of all deals.
     *
     * @return int
     */
    public static function countAll(): int
    {
        return DealsModel::all()->count();
    }

    /**
     * Get the count of all deactivated deals.
     *
     * @return int
     */
    public static function getDeactivated(): int
    {
        return DealsModel::where('is_active', '=', 0)->count();
    }

    /**
     * Get paginated list of deals.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public static function getPaginate(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return DealsModel::orderByDesc('id')
            ->paginate(SettingsModel::where('key', 'pagination_size')
                ->get()->last()->value);
    }
}
