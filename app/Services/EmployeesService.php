<?php

namespace App\Services;

use App\Models\EmployeesModel;

class EmployeesService
{
    private $employeesModel;

    public function __construct()
    {
        $this->employeesModel = new EmployeesModel();
    }

    public function loadCountEmployees()
    {
        return $this->employeesModel->getCountEmployees();
    }

    public function loadDeactivatedEmployees()
    {
        return $this->employeesModel->getCountOfDeactivatedEmployees();
    }

    public function loadEmployeesInLatestMonth()
    {
        return $this->employeesModel->getCountOfEmployeesInLatestMonth();
    }

    public function loadEmployeesAssignedToEmployee($clientId)
    {
        return $this->employeesModel->getEmployeesAssignedToEmployee($clientId);
    }

    public function getEmployeesDetailsAssignedToEmployee($clientId)
    {
        return $this->employeesModel->getEmployeesDetailsAssignedToEmployee($clientId);
    }

    public function loadEmployeesList()
    {
        return $this->employeesModel->getEmployees();
    }

    public function execute($validatedData)
    {
        $employeesModel = new EmployeesModel();

        $employeesModel->full_name = $validatedData->full_name;
        $employeesModel->phone = $validatedData->phone;
        $employeesModel->email = $validatedData->email;
        $employeesModel->section = $validatedData->section;
        $employeesModel->budget = $validatedData->budget;
        $employeesModel->location = $validatedData->location;
        $employeesModel->zip = $validatedData->zip;
        $employeesModel->city = $validatedData->city;
        $employeesModel->country = $validatedData->country;

        if ($employeesModel->save()) {
            return $employeesModel;
        } else {
            return false;
        }
    }

    public function loadEmployeeDetails($clientId)
    {
        $employeeDetails = $this->employeesModel->getEmployeesDetails($clientId);

        if($employeeDetails == null) {
            return false;
        }

//        $clientDetails = Arr::add($clientDetails, 'assignedCompaniesCount', $this->companiesService->loadCompaniesAssignedToEmployee($clientId));
//        $clientDetails = Arr::add($clientDetails, 'assignedEmployeesCount', $this->employeesService->loadEmployeesAssignedToEmployee($clientId));

        return [
            'employeeDetails' => $employeeDetails,
//            'assignedCompaniesDetails' => $this->companiesService->getCompaniesDetailsAssignedToEmployee($clientId),
//            'assignedEmployeesDetails' => $this->employeesService->getEmployeesDetailsAssignedToEmployee($clientId)
        ];
    }

    public function loadEmployeeDelete($clientId)
    {
        return $this->employeesModel->deleteEmployee($clientId);
    }

    public function checkIfEmployeeHaveAssignedCompanies($clientId)
    {
        $assignedCompanies = $this->companiesService->loadCompaniesAssignedToEmployee($clientId);

        if ($assignedCompanies != 0) {
            return true;
        } else {
            return false;
        }
    }

    public function checkIfEmployeeHaveAssignedEmployees($clientId)
    {
        $assignedEmployees = $this->employeesService->loadEmployeesAssignedToEmployee($clientId);

        if ($assignedEmployees != 0) {
            return true;
        } else {
            return false;
        }
    }

    public function update($validatedData, int $clientId)
    {
        $this->employeesModel = EmployeesModel::find($clientId);

        if (isset($this->employeesModel)) {
            if (isset($validatedData->full_name))
                $this->employeesModel->full_name = $validatedData->full_name;

            if (isset($validatedData->phone) && count($validatedData->phone) != 0)
                $this->employeesModel->phone = $validatedData->phone;

            if (isset($validatedData->email) && count($validatedData->email) != 0)
                $this->employeesModel->email = $validatedData->email;

            if (isset($validatedData->section) && count($validatedData->section) != 0)
                $this->employeesModel->section = $validatedData->section;

            if (isset($validatedData->budget) && count($validatedData->budget) != 0)
                $this->employeesModel->budget = $validatedData->budget;

            if (isset($validatedData->location) && count($validatedData->location) != 0)
                $this->employeesModel->location = $validatedData->location;

            if (isset($validatedData->zip) && count($validatedData->zip) != 0)
                $this->employeesModel->zip = $validatedData->zip;

            if (isset($validatedData->city) && count($validatedData->city) != 0)
                $this->employeesModel->city = $validatedData->city;

            if (isset($validatedData->country) && count($validatedData->country) != 0)
                $this->employeesModel->country = $validatedData->country;

            if ($this->employeesModel->save()) {
                return $this->employeesModel;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function setIsActive(int $employeId, $value)
    {
        $employeesModel = EmployeesModel::find($employeId);

        $employeesModel->is_active = $value == 1 ? false : true;

        if ($employeesModel->save()) {
            return $employeesModel;
        } else {
            return false;
        }
    }
}