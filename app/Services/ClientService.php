<?php
/**
 * Created by PhpStorm.
 * User: kamilgrzechulski
 * Date: 30.07.2018
 * Time: 09:20
 */

namespace App\Services;

use App\Models\ClientsModel;
use Config;

class ClientService
{
    private $clientsModel;

    public function __construct()
    {
        $this->clientsModel = new ClientsModel();
    }

    public function checkIfClientHaveForeignKey($id)
    {
        $data = $this->clientsModel->findClientByGivenClientId($id);

        $countCompanies = $data->companies()->count();
        $countEmployees = $data->employees()->count();

        if ($countCompanies > 0) {
            return $this->getMessage('messages.firstDeleteCompanies');
        }
        if ($countEmployees > 0) {
            return $this->getMessage('messages.firstDeleteEmployees');
        }

        return true;
    }

    public function processDeleteRow($id)
    {
        $data = $this->clientsModel->findClientByGivenClientId($id);

        $this->systemLogs->insertSystemLogs('ClientsModel has been deleted with id: ' . $data->id, 200);

        return $data->delete();
    }

    public function processIsActive($id, $value)
    {
        $clientDetails = $this->clientsModel->findClientByGivenClientId($id);

        if ($this->clientsModel->setActive($clientDetails->id, $value)) {
            return $this->getMessage('messages.SuccessClientActive');
        } else {
            return $this->getMessage('messages.ClientIsActived');
        }
    }

    public function loadClientSortedBy(string $string)
    {
        return $this->clientsModel->getClientSortedBy($string);
    }

    public function loadPagination()
    {
        return $this->clientsModel::paginate(Config::get('crm_settings.pagination_size'));
    }

    /**
     * @return array
     */
    public function getDataAndPagination()
    {
        $dataWithClients = [
            'client' => $this->loadClientSortedBy('created_at'),
            'clientPaginate' => $this->loadPagination()
        ];

        return $dataWithClients;
    }

    public function findClient(int $id)
    {
        return $this->clientsModel->findClientByGivenClientId($id);
    }

    /**
     * @param $rulesType
     * @return array
     */
    public function getRules($rulesType)
    {
        switch ($rulesType) {
            case 'STORE':
                return [
                    'full_name' => 'required|string',
                    'phone' => 'required',
                    'budget' => 'required',
                    'section' => 'required',
                    'email' => 'required|email',
                    'location' => 'required',
                    'zip' => 'required',
                    'city' => 'required',
                    'country' => 'required'
                ];
        }
    }

    public function loadRules()
    {
        return $this->clientsModel->getRules('STORE');
    }

    public function loadSearch($getValueInput)
    {
        return count($this->clientsModel->trySearchClientByValue('full_name', $getValueInput, 10));
    }

    public function execute($allInputs)
    {
        return $this->clientsModel->insertRow($allInputs);
    }

    public function update($id, $allInputs)
    {
        return $this->clientsModel->updateRow($id, $allInputs);
    }
}