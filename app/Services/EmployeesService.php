<?php

namespace App\Services;

use App\Models\EmployeesModel;
use Config;

class EmployeesService
{
    private $employeesModel;

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

    public function loadEmployees()
    {
        return $this->employeesModel->getEmployees();
    }

    public function loadPaginate()
    {
        return $this->employeesModel::paginate(Config::get('crm_settings.pagination_size'));
    }

    public function pluckData()
    {
        return $this->employeesModel::pluck('full_name', 'id');
    }

    public function loadEmployeeDetails(int $employeeId)
    {
        return $this->employeesModel->getEmployeeDetails($employeeId);
    }

    public function countEmployeeTasks(EmployeesModel $dataOfEmployees)
    {
        return $dataOfEmployees->tasks()->get()->count();
    }

    public function loadIsActiveFunction(int $employeeId, int $value)
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
        return $this->employeesModel->getEmployeesInLatestMonth() . '%' ? : '0.00%';
    }

    public function loadDeactivatedEmployees()
    {
        return $this->employeesModel->getDeactivated();
    }
}