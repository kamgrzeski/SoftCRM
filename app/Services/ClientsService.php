<?php

namespace App\Services;

use App\Models\ClientsModel;
use Illuminate\Support\Arr;

class ClientsService
{
    private $clientsModel;
    private $companiesService;
    private $employeesService;

    public function __construct()
    {
        $this->clientsModel = new ClientsModel();
        $this->companiesService = new CompaniesService();
        $this->employeesService = new EmployeesService();
    }

    public function loadCountClients()
    {
        return $this->clientsModel->getCountClients();
    }

    public function loadDeactivatedClients()
    {
        return $this->clientsModel->getCountOfDeactivatedClients();
    }

    public function loadClientsInLatestMonth()
    {
        return $this->clientsModel->getCountOfClientsInLatestMonth();
    }

    public function loadClientsList()
    {
        return $this->clientsModel->getClients();
    }

    public function execute($validatedData)
    {
        $clientsModel = new ClientsModel();

        $clientsModel->full_name = $validatedData->full_name;
        $clientsModel->phone = $validatedData->phone;
        $clientsModel->email = $validatedData->email;
        $clientsModel->section = $validatedData->section;
        $clientsModel->budget = $validatedData->budget;
        $clientsModel->location = $validatedData->location;
        $clientsModel->zip = $validatedData->zip;
        $clientsModel->city = $validatedData->city;
        $clientsModel->country = $validatedData->country;

        if ($clientsModel->save()) {
            return $clientsModel;
        } else {
            return false;
        }
    }

    public function loadClientDetails($clientId)
    {
        $clientDetails = $this->clientsModel->getClientsDetails($clientId);

        if($clientDetails == null) {
            return false;
        }

        $clientDetails = Arr::add($clientDetails, 'assignedCompaniesCount', $this->companiesService->loadCompaniesAssignedToClient($clientId));
        $clientDetails = Arr::add($clientDetails, 'assignedEmployeesCount', $this->employeesService->loadEmployeesAssignedToClient($clientId));

        return [
            'clientDetails' => $clientDetails,
            'assignedCompaniesDetails' => $this->companiesService->getCompaniesDetailsAssignedToClient($clientId),
            'assignedEmployeesDetails' => $this->employeesService->getEmployeesDetailsAssignedToClient($clientId)
        ];
    }

    public function loadClientDelete($clientId)
    {
        return $this->clientsModel->deleteClient($clientId);
    }

    public function checkIfClientHaveAssignedCompanies($clientId)
    {
        $assignedCompanies = $this->companiesService->loadCompaniesAssignedToClient($clientId);

        if ($assignedCompanies != 0) {
            return true;
        } else {
            return false;
        }
    }

    public function checkIfClientHaveAssignedEmployees($clientId)
    {
        $assignedEmployees = $this->employeesService->loadEmployeesAssignedToClient($clientId);

        if ($assignedEmployees != 0) {
            return true;
        } else {
            return false;
        }
    }

    public function update($validatedData, int $clientId)
    {
        $this->clientsModel = ClientsModel::find($clientId);

        if (isset($this->clientsModel)) {
            if (isset($validatedData->full_name))
                $this->clientsModel->full_name = $validatedData->full_name;

            if (isset($validatedData->phone) && count($validatedData->phone) != 0)
                $this->clientsModel->phone = $validatedData->phone;

            if (isset($validatedData->email) && count($validatedData->email) != 0)
                $this->clientsModel->email = $validatedData->email;

            if (isset($validatedData->section) && count($validatedData->section) != 0)
                $this->clientsModel->section = $validatedData->section;

            if (isset($validatedData->budget) && count($validatedData->budget) != 0)
                $this->clientsModel->budget = $validatedData->budget;

            if (isset($validatedData->location) && count($validatedData->location) != 0)
                $this->clientsModel->location = $validatedData->location;

            if (isset($validatedData->zip) && count($validatedData->zip) != 0)
                $this->clientsModel->zip = $validatedData->zip;

            if (isset($validatedData->city) && count($validatedData->city) != 0)
                $this->clientsModel->city = $validatedData->city;

            if (isset($validatedData->country) && count($validatedData->country) != 0)
                $this->clientsModel->country = $validatedData->country;

            if ($this->clientsModel->save()) {
                return $this->clientsModel;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function setIsActive(int $clientId, $value)
    {
        $clientsModel = ClientsModel::find($clientId);

        $clientsModel->is_active = $value == 1 ? false : true;

        if ($clientsModel->save()) {
            return $clientsModel;
        } else {
            return false;
        }
    }
}