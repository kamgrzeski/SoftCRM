<?php

namespace App\Queries;

use App\Models\Client;
use App\Models\Setting;

/**
 * Class ClientsQueries
 *
 * Query class for handling operations related to the ClientsModel.
 */
class ClientQueries
{
    /**
     * Get all clients.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return Client::all();
    }

    /**
     * Get paginated list of clients.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public static function getPaginate(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return Client::orderByDesc('id')
            ->paginate(Setting::where('key', 'pagination_size')
                ->get()->last()->value);
    }

    /**
     * Get the count of all deactivated clients.
     *
     * @return int
     */
    public static function getDeactivated(): int
    {
        return Client::where('is_active', '=', 0)->count();
    }

    /**
     * Get the count of all clients.
     *
     * @return int
     */
    public static function getCountAll(): int
    {
        return Client::all()->count();
    }

    /**
     * Get the count of all clients created in the latest month.
     *
     * @return int
     */
    public static function getCountAllInLatestMonth(): int
    {
        return Client::where('created_at', '>=', now()->subMonth())->count();
    }
}
