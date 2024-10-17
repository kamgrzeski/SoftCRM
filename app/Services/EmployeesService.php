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
     */
    public function loadEmployees(): \Illuminate\Support\Collection
    {
        $employees = EmployeesModel::orderBy('created_at')->get();

        foreach($employees as $key => $employee) {
            Arr::add($employees[$key], 'taskCount', TasksQueries::getEmployeesTaskCount($employee->id));
        }

        return $employees;
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
