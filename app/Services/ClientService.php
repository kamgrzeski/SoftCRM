<?php

namespace App\Services;

use App\Models\Client;
use App\Queries\ClientQueries;
use App\Queries\SettingQueries;
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

    /**
     * Load details of a specific client.
     *
     * @param Client $client
     * @return Client
     */
    public function loadClientDetails(Client $client): Client
    {
        $client->formattedBudget = Money::{SettingQueries::getSettingValue('currency')}($client->budget);

        return $client;
    }

    /**
     * Load the list of clients added in the latest month.
     *
     * @return float
     */
    public function loadClientsInLatestMonth(): float
    {
        $clientsCountInLatestMonth = ClientQueries::getCountAllInLatestMonth();

        $allClientCount = ClientQueries::getCountAll();

        return ($allClientCount / 100) * $clientsCountInLatestMonth;
    }
}
