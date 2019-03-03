<?php
/**
 * Created by PhpStorm.
 * User: kamilgrzechulski
 * Date: 30.07.2018
 * Time: 09:20
 */

namespace App\Services;

use App\Models\EmployeesModel;
use App\Models\Language;
use Config;
use phpDocumentor\Reflection\Types\This;

class EmployeesService
{
    private $language;
    private $employeesModel;
    private $systemLogs;

    public function __construct()
    {
        $this->language = new Language();
        $this->employeesModel = new EmployeesModel();
        $this->systemLogs = new SystemLogService();
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

    public function loadRules()
    {
        return $this->employeesModel->getRules('STORE');
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

    public function loadSearch($getValueInput)
    {
        return count($this->employeesModel->trySearchEmployeesByValue('full_name', $getValueInput, 10));
    }
}