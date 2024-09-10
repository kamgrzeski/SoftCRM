<?php

namespace App\Queries;

use App\Models\FinancesModel;
use App\Models\SettingsModel;

/**
 * Class FinancesQueries
 *
 * Query class for handling operations related to the FinancesModel.
 */
class FinancesQueries
{
    /**
     * Get the count of all finance records.
     *
     * @return int
     */
    public static function countAll(): int
    {
        return FinancesModel::count();
    }

    /**
     * Get paginated list of finance records.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public static function getPaginate(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return FinancesModel::orderByDesc('id')
            ->paginate(SettingsModel::where('key', 'pagination_size')
                ->get()->last()->value);
    }
}
