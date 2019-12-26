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

    public function execute($requestedData)
    {
        return $this->dealsModel->insertDeal($requestedData);
    }

    public function update(int $dealId, $requestedData)
    {
        return $this->dealsModel->updateDeal($dealId, $requestedData);
    }

    public function loadDeals()
    {
        return DealsModel::all()->sortByDesc('created_at');
    }

    public function loadPaginate()
    {
        return $this->dealsModel->getPaginate();
    }

    public function loadDeal(int $dealId)
    {
        return $this->dealsModel->getDeal($dealId);
    }

    public function pluckCompanies()
    {
        return $this->dealsModel->getPluckCompanies();
    }

    public function loadSetActive(int $dealId, bool $value)
    {
        return $this->dealsModel->setActive($dealId, $value);
    }

    public function loadCountDeals()
    {
        return $this->dealsModel->countDeals() ? : 0;
    }

    public function loadDeactivatedDeals()
    {
        return $this->dealsModel->getDeactivated() ? : 0;
    }

    public function loadDealsInLatestMonth()
    {
        return $this->dealsModel->getDealsInLatestMonth() . '%' ? : '0.00%';
    }

    public function loadDataAndPagination()
    {
        $dataOfDeals = [
            'deals' => $this->loadDeals(),
            'dealsPaginate' => $this->loadPaginate()
        ];

        return $dataOfDeals;
    }
}