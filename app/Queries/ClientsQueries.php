<?php

namespace App\Queries;

use App\Models\ClientsModel;
use App\Models\SettingsModel;

/**
 * Class ClientsQueries
 *
 * Query class for handling operations related to the ClientsModel.
 */
class ClientsQueries
{
    /**
     * Get all clients.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return ClientsModel::all();
    }

    /**
     * Get paginated list of clients.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public static function getPaginate(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return ClientsModel::orderByDesc('id')
            ->paginate(SettingsModel::where('key', 'pagination_size')
                ->get()->last()->value);
    }

    /**
     * Get the count of all deactivated clients.
     *
     * @return int
     */
    public static function getDeactivated(): int
    {
        return ClientsModel::where('is_active', '=', 0)->count();
    }

    /**
     * Get the count of all clients.
     *
     * @return int
     */
    public static function getCountAll(): int
    {
        return ClientsModel::all()->count();
    }

    /**
     * Get the count of all clients created in the latest month.
     *
     * @return int
     */
    public static function getCountAllInLatestMonth(): int
    {
        return ClientsModel::where('created_at', '>=', now()->subMonth())->count();
    }
}
