<?php

namespace App\Services;

use App\Models\ClientsModel;
use App\Models\ContactsModel;
use App\Models\EmployeesModel;
use Config;

class ContactsService
{
    private $contactsModel;

    public function __construct()
    {
        $this->contactsModel = new ContactsModel();
    }

    public function getContacts()
    {
        return $this->contactsModel->getAllContacts();
    }

    public function getPaginate()
    {
        return $this->contactsModel::paginate(Config::get('crm_settings.pagination_size'));
    }

    public function execute($allInputs)
    {
        return $this->contactsModel->insertRow($allInputs);
    }

    public function getContact(int $id)
    {
        return $this->contactsModel::find($id);
    }

    public function collectDataForView()
    {
        return (object)[
            'dataOfClients' => ClientsModel::pluck('full_name', 'id'),
            'dataOfEmployees' => EmployeesModel::pluck('full_name', 'id')
        ];
    }
}