<?php

namespace App\Services;

use App\Models\EmployeesModel;
use App\Models\SettingsModel;

class EmployeesService
{
    private EmployeesModel $employeesModel;

    public function __construct()
    {
        $this->employeesModel = new EmployeesModel();
    }

    public function loadEmployees($createForm = false)
    {
        return $this->employeesModel->getEmployees($createForm);
    }

    public function loadPaginate()
    {
        return $this->employeesModel->getPaginate();
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
