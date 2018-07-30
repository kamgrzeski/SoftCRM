<?php
/**
 * Created by PhpStorm.
 * User: kamilgrzechulski
 * Date: 30.07.2018
 * Time: 09:20
 */

namespace App\Services;

use App\Models\ClientsModel;
use App\Models\Language;

class ClientService
{
    private $language;

    private $clientsModel;

    private $systemLogs;

    public function __construct()
    {
        $this->language = new Language();

        $this->clientsModel = new ClientsModel();

        $this->systemLogs = new SystemLogService();
    }

    public function checkIfClientHaveForeignKey($id)
    {
        $data = $this->clientsModel->findClientByGivenClientId($id);

        $countCompanies = $data->companies()->count();
        $countEmployees = $data->employees()->count();

        if ($countCompanies > 0) {
            return $this->language->getMessage('messages.firstDeleteCompanies');
        }
        if ($countEmployees > 0) {
            return $this->language->getMessage('messages.firstDeleteEmployees');
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
            return $this->language->getMessage('messages.SuccessClientActive');
        } else {
            return $this->language->getMessage('messages.ClientIsActived');
        }
    }

}