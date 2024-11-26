<?php

namespace App\Services;

use App\Models\Employee;
use App\Queries\EmployeeQueries;
use App\Queries\TaskQueries;
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
        $employees = Employee::orderBy('created_at')->get();

        foreach($employees as $key => $employee) {
            Arr::add($employees[$key], 'taskCount', TaskQueries::getEmployeesTaskCount($employee->id));
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
        $employeesCountInLatestMonth = EmployeeQueries::getEmployeesInLatestMonth();
        $allEmployees = EmployeeQueries::countAll();

        return ($allEmployees / 100) * $employeesCountInLatestMonth;
    }
}
