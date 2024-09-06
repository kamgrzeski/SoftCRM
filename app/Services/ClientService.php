<?php

namespace App\Services;

use App\Models\ClientsModel;
use App\Models\SettingsModel;
use App\Traits\Language;
use Cknow\Money\Money;

class ClientService
{
    use Language;

    private ClientsModel $clientsModel;

    public function __construct()
    {
        $this->clientsModel = new ClientsModel();
    }

    public function loadClients(bool $createForm = false)
    {
        $query = $this->clientsModel->getClientSortedBy($createForm);

        foreach($query as $key => $client) {
            $query[$key]->budget = Money::{SettingsModel::getSettingValue('currency')}($client->budget);
        }

        return $query;
    }

    public function loadPagination()
    {
        return $this->clientsModel->getPaginate();
    }

    public function loadClientDetails(ClientsModel $client)
    {
        $client->formattedBudget = Money::{SettingsModel::getSettingValue('currency')}($client->budget);

        return $client;
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
