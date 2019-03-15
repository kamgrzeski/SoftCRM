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
    public function getDataAndPagination()
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

    public function loadEmployeeDetails(int $id)
    {
        return $this->employeesModel->getEmployeeDetails($id);
    }

    public function countEmployeeContacts(EmployeesModel $dataOfEmployees)
    {
        return count($dataOfEmployees->contacts()->get());
    }

    public function countEmployeeTasks(EmployeesModel $dataOfEmployees)
    {
        return count($dataOfEmployees->tasks()->get());
    }

    public function loadIsActiveFunction(int $id, int $value)
    {
        return $this->employeesModel->setActive($id, $value);
    }

    public function execute($allInputs)
    {
        return $this->employeesModel->insertRow($allInputs);
    }

    public function update(int $id, $allInputs)
    {
        return $this->employeesModel->updateRow($id, $allInputs);
    }

    public function getPluckClients()
    {
        return $this->employeesModel->getClients();
    }
}