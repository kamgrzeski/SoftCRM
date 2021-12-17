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

        if ($client->companies()->count() > 0) {
            return $this->getMessage('messages.firstDeleteCompanies');
        }
        if ($client->employees()->count() > 0) {
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

        return $this->clientsModel->setClientActive($clientDetails->id, $value);
    }

    public function loadClients($createForm = false)
    {
        return $this->clientsModel->getClientSortedBy($createForm);
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
        return $this->clientsModel->getClientsInLatestMonth();
    }
}
