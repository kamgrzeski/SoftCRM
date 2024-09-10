<?php

namespace App\Services;

use App\Models\ClientsModel;
use App\Models\SettingsModel;
use App\Queries\ClientsQueries;
use App\Queries\SettingsQueries;
use App\Traits\Language;
use Cknow\Money\Money;

/**
 * Class ClientService
 *
 * Service class for handling operations related to the ClientsModel.
 */
class ClientService
{
    use Language;

    private ClientsModel $clientsModel;

    /**
     * ClientService constructor.
     *
     * Initializes a new instance of the ClientsModel.
     */
    public function __construct()
    {
        $this->clientsModel = new ClientsModel();
    }

    /**
     * Load paginated list of clients.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function loadPagination(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return ClientsQueries::getPaginate();
    }

    /**
     * Load details of a specific client.
     *
     * @param ClientsModel $client
     * @return ClientsModel
     */
    public function loadClientDetails(ClientsModel $client): ClientsModel
    {
        $client->formattedBudget = Money::{SettingsQueries::findByKey('currency')}($client->budget);

        return $client;
    }

    /**
     * Load the count of all clients.
     *
     * @return int
     */
    public function loadCountClients(): int
    {
        return ClientsQueries::getCountAll();
    }

    /**
     * Load the list of deactivated clients.
     *
     * @return int
     */
    public function loadDeactivatedClients(): int
    {
        return ClientsQueries::getDeactivated();
    }

    /**
     * Load the list of clients added in the latest month.
     *
     * @return float
     */
    public function loadClientsInLatestMonth(): float
    {
        $clientsCountInLatestMonth = ClientsQueries::getCountAllInLatestMonth();

        $allClientCount = ClientsQueries::getCountAll();

        return ($allClientCount / 100) * $clientsCountInLatestMonth;
    }
}
