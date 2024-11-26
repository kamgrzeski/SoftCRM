<?php

namespace App\Queries;

use App\Models\Setting;
use App\Models\SystemLog;

/**
 * Class SystemLogsQueries
 *
 * Query class for handling operations related to the SystemLogsModel.
 */
class SystemLogQueries
{
    /**
     * Get the count of all system logs.
     *
     * @return int
     */
    public static function countAll(): int
    {
        return SystemLog::count();
    }

    /**
     * Get all system logs.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return SystemLog::all();
    }

    /**
     * Get paginated list of system logs.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public static function getPaginate(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return SystemLog::paginate(Setting::where('key', 'pagination_size')
            ->get()->last()->value);
    }
}
