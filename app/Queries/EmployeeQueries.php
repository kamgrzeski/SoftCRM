<?php

namespace App\Queries;

use App\Models\Employee;
use App\Models\Setting;

/**
 * Class EmployeesQueries
 *
 * Query class for handling operations related to the EmployeesModel.
 */
class EmployeeQueries
{
    /**
     * Get the count of all deactivated employees.
     *
     * @return int
     */
    public static function getDeactivated(): int
    {
        return Employee::where('is_active', '=', 0)->count();
    }

    /**
     * Get the percentage of employees created in the latest month.
     *
     * @return float
     */
    public static function getEmployeesInLatestMonth(): float
    {
        return Employee::where('created_at', '>=', now()->subMonth())->count();
    }

    /**
     * Get the count of all employees.
     *
     * @return int
     */
    public static function countAll(): int
    {
        return Employee::all()->count();
    }

    /**
     * Get paginated list of employees.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public static function getPaginate(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return Employee::orderByDesc('id')
            ->paginate(Setting::where('key', 'pagination_size')
                ->get()->last()->value);
    }
}
