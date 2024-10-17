<?php

namespace App\Services;

use App\Models\ClientsModel;
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

    /**
     * Load details of a specific client.
     *
     * @param ClientsModel $client
     * @return ClientsModel
     */
    public function loadClientDetails(ClientsModel $client): ClientsModel
    {
        $client->formattedBudget = Money::{SettingsQueries::getSettingValue('currency')}($client->budget);

        return $client;
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
