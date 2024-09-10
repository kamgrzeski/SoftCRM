<?php

namespace App\Queries;

use App\Models\EmployeesModel;
use App\Models\SettingsModel;

/**
 * Class EmployeesQueries
 *
 * Query class for handling operations related to the EmployeesModel.
 */
class EmployeesQueries
{
    /**
     * Get the count of all deactivated employees.
     *
     * @return int
     */
    public static function getDeactivated(): int
    {
        return EmployeesModel::where('is_active', '=', 0)->count();
    }

    /**
     * Get the percentage of employees created in the latest month.
     *
     * @return float
     */
    public static function getEmployeesInLatestMonth(): float
    {
        $employeesCount = EmployeesModel::where('created_at', '>=', now()->subMonth())->count();
        $allEmployees = self::countAll();

        return ($allEmployees / 100) * $employeesCount;
    }

    /**
     * Get the count of all employees.
     *
     * @return int
     */
    public static function countAll(): int
    {
        return EmployeesModel::all()->count();
    }

    /**
     * Get paginated list of employees.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public static function getPaginate(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return EmployeesModel::orderByDesc('id')
            ->paginate(SettingsModel::where('key', 'pagination_size')
                ->get()->last()->value);
    }
}
