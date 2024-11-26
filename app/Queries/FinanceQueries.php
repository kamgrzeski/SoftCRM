<?php

namespace App\Queries;

use App\Models\Finance;
use App\Models\Setting;

/**
 * Class FinancesQueries
 *
 * Query class for handling operations related to the FinancesModel.
 */
class FinanceQueries
{
    /**
     * Get the count of all finance records.
     *
     * @return int
     */
    public static function countAll(): int
    {
        return Finance::count();
    }

    /**
     * Get paginated list of finance records.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public static function getPaginate(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return Finance::orderByDesc('id')
            ->paginate(Setting::where('key', 'pagination_size')
                ->get()->last()->value);
    }
}
