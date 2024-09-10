<?php

namespace App\Services;

use App\Models\EmployeesModel;
use App\Queries\EmployeesQueries;
use App\Queries\TasksQueries;
use Illuminate\Support\Arr;

/**
 * Class EmployeesService
 *
 * Service class for handling operations related to the EmployeesModel.
 */
class EmployeesService
{
    /**
     * Load all employees, optionally for creating a form.
     *
     * @param bool $createForm Whether to load employees for creating a form.
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function loadEmployees(bool $createForm = false): \Illuminate\Database\Eloquent\Collection
    {
        if($createForm) {
            return EmployeesModel::pluck('full_name', 'id');
        }

        $query = EmployeesModel::all()->sortBy('created_at');

        foreach($query as $key => $value) {
            Arr::add($query[$key], 'taskCount', TasksQueries::getEmployeesTaskCount($value->id));
        }

        return $query;
    }

    /**
     * Load paginated list of employees.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function loadPaginate(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return EmployeesQueries::getPaginate();
    }

    /**
     * Load the count of all employees.
     *
     * @return int
     */
    public function loadCountEmployees(): int
    {
        return EmployeesQueries::countAll();
    }

    /**
     * Load the list of employees added in the latest month.
     *
     * @return int
     */
    public function loadEmployeesInLatestMonth(): int
    {
        return EmployeesQueries::getEmployeesInLatestMonth();
    }

    /**
     * Load the list of deactivated employees.
     *
     * @return int
     */
    public function loadDeactivatedEmployees(): int
    {
        return EmployeesQueries::getDeactivated();
    }
}
