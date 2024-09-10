<?php

namespace App\Queries;

use App\Models\SettingsModel;
use App\Models\SystemLogsModel;

/**
 * Class SystemLogsQueries
 *
 * Query class for handling operations related to the SystemLogsModel.
 */
class SystemLogsQueries
{
    /**
     * Get the count of all system logs.
     *
     * @return int
     */
    public static function countAll(): int
    {
        return SystemLogsModel::count();
    }

    /**
     * Get all system logs.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return SystemLogsModel::all();
    }

    /**
     * Get paginated list of system logs.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public static function getPaginate(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return SystemLogsModel::paginate(SettingsModel::where('key', 'pagination_size')
            ->get()->last()->value);
    }
}
