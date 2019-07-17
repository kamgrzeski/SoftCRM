<?php

namespace App\Services;

use App\Models\CompaniesModel;

class CompaniesService
{
    private $companiesModel;

    public function __construct()
    {
        $this->companiesModel = new CompaniesModel();
    }

    public function loadCountCompanies()
    {
        return $this->companiesModel->getCountCompanies();
    }

    public function loadDeactivatedCompanies()
    {
        return $this->companiesModel->getCountOfDeactivatedCompanies();
    }

    public function loadCompaniesInLatestMonth()
    {
        return $this->companiesModel->getCountOfDeactivatedCompaniesInLatestMonth();
    }

    public function loadCompanies()
    {
        return $this->companiesModel->getCompanies();
    }

    public function loadCompaniesAssignedToClient($clientId)
    {
        return $this->companiesModel->getCompaniesAssignedToClient($clientId);
    }

    public function getCompaniesDetailsAssignedToClient($clientId)
    {
        return $this->companiesModel->getCompaniesDetailsAssignedToClient($clientId);
    }
}