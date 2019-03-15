<?php

namespace App\Services;

use App\Models\ClientsModel;
use App\Models\CompaniesModel;
use App\Models\InvoicesModel;
use App\Models\ProductsModel;
use Config;

class InvoicesService
{
    private $invoicesModel;

    public function __construct()
    {
        $this->invoicesModel = new InvoicesModel();
    }

    public function getInvoices()
    {
        return InvoicesModel::all()->sortByDesc('created_at');
    }

    public function getPagination()
    {
        return $this->invoicesModel::paginate(Config::get('crm_settings.pagination_size'));
    }

    public function execute($allInputs)
    {
        return $this->invoicesModel->insertRow($allInputs);
    }

    public function getInvoice(int $id)
    {
        return $this->invoicesModel::find($id);
    }

    public function update(int $id, $allInputs)
    {
        return $this->invoicesModel->updateRow($id, $allInputs);
    }

    public function loadIsActiveFunction($id, $value)
    {
        return $this->invoicesModel->setActive($id, $value);
    }

    public function collectDataForView()
    {
        return (object)[
            'dataOfCompanies' => CompaniesModel::pluck('name', 'id'),
            'dataOfClient' => ClientsModel::pluck('full_name', 'id'),
            'dataOfProducts' => ProductsModel::pluck('name', 'id')
        ];
    }
}