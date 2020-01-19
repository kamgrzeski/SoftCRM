<?php

namespace App\Services;

use App\Models\DealsModel;

class DealsService
{
    private $dealsModel;

    public function __construct()
    {
        $this->dealsModel = new DealsModel();
    }

    public function execute(array $requestedData, int $adminId)
    {
        return $this->dealsModel->storeDeal($requestedData, $adminId);
    }

    public function update(int $dealId, array $requestedData)
    {
        return $this->dealsModel->updateDeal($dealId, $requestedData);
    }

    public function loadDeals()
    {
        return DealsModel::all()->sortBy('created_at');
    }

    public function loadPaginate()
    {
        return $this->dealsModel->getPaginate();
    }

    public function loadDeal(int $dealId)
    {
        return $this->dealsModel->getDeal($dealId);
    }

    public function pluckDeals()
    {
        return $this->dealsModel->getPluckCompanies();
    }

    public function loadSetActive(int $dealId, bool $value)
    {
        return $this->dealsModel->setActive($dealId, $value);
    }

    public function loadCountDeals()
    {
        return $this->dealsModel->countDeals();
    }

    public function loadDeactivatedDeals()
    {
        return $this->dealsModel->getDeactivated();
    }

    public function loadDealsInLatestMonth()
    {
        return $this->dealsModel->getDealsInLatestMonth() . '%' ? : '0.00%';
    }
}