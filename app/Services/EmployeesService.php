<?php

namespace App\Services;

use App\Models\EmployeesModel;
use App\Models\SettingsModel;
use Config;

class EmployeesService
{
    private EmployeesModel $employeesModel;

    public function __construct()
    {
        $this->employeesModel = new EmployeesModel();
    }

    public function execute(array $requestedData, int $adminId)
    {
        return $this->employeesModel->storeEmployee($requestedData, $adminId);
    }

    public function update(int $employeeId, array $requestedData)
    {
        return $this->employeesModel->updateEmployee($employeeId, $requestedData);
    }

    public function loadEmployees($createForm = false)
    {
        return $this->employeesModel->getEmployees($createForm);
    }

    public function loadPaginate()
    {
        return $this->employeesModel::paginate(SettingsModel::where('key', 'pagination_size')->get()->last()->value);
    }

    public function loadEmployeeDetails(int $employeeId)
    {
        return $this->employeesModel->getEmployeeDetails($employeeId);
    }

    public function countEmployeeTasks(EmployeesModel $dataOfEmployees)
    {
        return $dataOfEmployees->tasks()->get()->count();
    }

    public function loadSetActive(int $employeeId, int $value)
    {
        return $this->employeesModel->setActive($employeeId, $value);
    }

    public function loadPluckClients()
    {
        return $this->employeesModel->getClients();
    }

    public function loadCountEmployees()
    {
        return $this->employeesModel->countEmployees();
    }

    public function loadEmployeesInLatestMonth()
    {
        return $this->employeesModel->getEmployeesInLatestMonth();
    }

    public function loadDeactivatedEmployees()
    {
        return $this->employeesModel->getDeactivated();
    }
}
