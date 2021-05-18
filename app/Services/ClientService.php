<?php

namespace App\Services;

use App\Models\ClientsModel;
use App\Traits\Language;

class ClientService
{
    use Language;

    private ClientsModel $clientsModel;

    public function __construct()
    {
        $this->clientsModel = new ClientsModel();
    }

    public function execute(array $requestedData, int $adminId): int
    {
        return $this->clientsModel->storeClient($requestedData, $adminId);
    }

    public function update(int $clientId, array $requestedData): int
    {
        return $this->clientsModel->updateClient($clientId, $requestedData);
    }

    public function checkIfClientHaveAssignedEmployeeOrCompany(int $clientId)
    {
        $client = $this->clientsModel->getClientByGivenClientId($clientId);

        $countCompanies = $client->companies()->count();
        $countEmployees = $client->employees()->count();

        if ($countCompanies > 0) {
            return $this->getMessage('messages.firstDeleteCompanies');
        }
        if ($countEmployees > 0) {
            return $this->getMessage('messages.firstDeleteEmployees');
        }

        return true;
    }

    public function loadDeleteClient(int $clientId): ?bool
    {
        return $this->clientsModel->deleteClient($clientId);
    }

    public function loadSetActive(int $clientId, bool $value)
    {
        $clientDetails = $this->clientsModel->getClientByGivenClientId($clientId);

        if ($this->clientsModel->setClientActive($clientDetails->id, $value)) {
            return $this->getMessage('messages.SuccessClientActive');
        } else {
            return $this->getMessage('messages.ClientIsActived');
        }
    }

    public function loadClients()
    {
        return $this->clientsModel->getClientSortedBy();
    }

    public function loadPagination()
    {
        return $this->clientsModel->getPaginate();
    }

    public function loadClientDetails(int $clientId)
    {
        return $this->clientsModel->getClientByGivenClientId($clientId);
    }

    public function loadCountClients()
    {
        return $this->clientsModel->countClients();
    }

    public function loadDeactivatedClients()
    {
        return $this->clientsModel->getDeactivated();
    }

    public function loadClientsInLatestMonth()
    {
        return $this->clientsModel->getClientsInLatestMonth() . '%' ? : '0.00%';
    }
}
