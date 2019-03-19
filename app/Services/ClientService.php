<?php
/**
 * Created by PhpStorm.
 * User: kamilgrzechulski
 * Date: 30.07.2018
 * Time: 09:20
 */

namespace App\Services;

use App\Models\ClientsModel;
use App\Traits\Language;
use phpDocumentor\Reflection\Types\This;

class ClientService
{
    use Language;

    private $clientsModel;

    public function __construct()
    {
        $this->clientsModel = new ClientsModel();
    }

    public function execute(array $requestedData)
    {
        return $this->clientsModel->storeClient($requestedData);
    }

    public function update(int $clientId, array $requestedData)
    {
        return $this->clientsModel->updateClient($clientId, $requestedData);
    }

    public function checkIfClientHaveAssignedEmployeeOrCompanie(int $clientId)
    {
        $client = $this->clientsModel->findClientByGivenClientId($clientId);

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

    public function loadDeleteClient(int $clientId)
    {
        $data = $this->clientsModel->findClientByGivenClientId($clientId);

        return $data->delete();
    }

    public function processIsActive(int $clientId, bool $value)
    {
        $clientDetails = $this->clientsModel->findClientByGivenClientId($clientId);

        if ($this->clientsModel->setClientActive($clientDetails->id, $value)) {
            return $this->getMessage('messages.SuccessClientActive');
        } else {
            return $this->getMessage('messages.ClientIsActived');
        }
    }

    public function loadClientSortedBy(string $string)
    {
        return $this->clientsModel->getClientSortedBy($string);
    }

    public function loadDataAndPagination()
    {
        $dataWithClients = [
            'client' => $this->loadClientSortedBy('created_at'),
            'clientPaginate' => $this->clientsModel->getPaginate()
        ];

        return $dataWithClients;
    }

    public function loadClientDetails(int $clientId)
    {
        return $this->clientsModel->findClientByGivenClientId($clientId);
    }

    public function countClients()
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