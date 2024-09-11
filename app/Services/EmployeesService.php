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
     */
    public function loadEmployees(bool $createForm = false): \Illuminate\Support\Collection
    {
        if($createForm) {
            return EmployeesModel::pluck('full_name', 'id');
        }

        $query = EmployeesModel::orderBy('created_at')->get();

        foreach($query as $key => $value) {
            Arr::add($query[$key], 'taskCount', TasksQueries::getEmployeesTaskCount($value->id));
        }

        return $query;
    }

    /**
     * Load the list of employees added in the latest month.
     *
     * @return int
     */
    public function loadEmployeesInLatestMonth(): int
    {
        $employeesCountInLatestMonth = EmployeesQueries::getEmployeesInLatestMonth();
        $allEmployees = EmployeesQueries::countAll();

        return ($allEmployees / 100) * $employeesCountInLatestMonth;
    }
}
