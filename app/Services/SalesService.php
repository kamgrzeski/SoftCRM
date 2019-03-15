<?php

namespace App\Services;

use App\Models\SalesModel;

class SalesService
{
    private $salesModel;

    public function __construct()
    {
        $this->salesModel = new SalesModel();
    }

    public function getSales()
    {
        return $this->salesModel::all()->sortByDesc('created_at');
    }

    public function getPaginate()
    {
        return $this->salesModel::paginate(Config::get('crm_settings.pagination_size'));
    }

    public function execute($allInputs)
    {
        return $this->salesModel->insertRow($allInputs);
    }

    public function getSale(int $id)
    {
        return $this->salesModel::find($id);
    }

    public function update($id, $allInputs)
    {
        return $this->salesModel->updateRow($id, $allInputs);
    }

    public function loadIsActiveFunction($id, $value)
    {
        return $this->salesModel->setActive($id, $value);
    }
}