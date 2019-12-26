<?php
/**
 * Created by PhpStorm.
 * User: kamilgrzechulski
 * Date: 30.07.2018
 * Time: 09:20
 */

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

    public function execute($requestedData)
    {
        return $this->employeesModel->insertEmployee($requestedData);
    }

    public function update(int $employeeId, $requestedData)
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

    /**
     * @return array
     */
    public function loadDataAndPagination()
    {
        $dataOfEmployees = [
            'employees' => $this->loadEmployees(),
            'employeesPaginate' => $this->loadPaginate()
        ];

        return $dataOfEmployees;
    }

    public function pluckData()
    {
        return $this->employeesModel::pluck('full_name', 'id');
    }

    public function loadEmployeeDetails(int $employeeId)
    {
        return $this->employeesModel->getEmployeeDetails($employeeId);
    }

    public function countEmployeeContacts($dataOfEmployees)
    {
        return $dataOfEmployees->contacts()->get()->count();
    }

    public function countEmployeeTasks($dataOfEmployees)
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
        return $this->employeesModel->countEmployees() ? : 0;
    }

    public function loadEmployeesInLatestMonth()
    {
        return $this->employeesModel->getEmployeesInLatestMonth() . '%' ? : '0.00%';
    }

    public function loadDeactivatedEmployees()
    {
        return $this->employeesModel->getDeactivated() ? : 0;
    }
}