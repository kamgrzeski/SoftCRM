<?php

namespace App\Services;

use App\Models\CompaniesModel;

class CompaniesService
{
    private CompaniesModel $companiesModel;

    public function __construct()
    {
        $this->companiesModel = new CompaniesModel();
    }

    public function loadCompanies(bool $createForm = false)
    {
        return $this->companiesModel->getAll($createForm);
    }

    public function loadPagination()
    {
        return $this->companiesModel->getPaginate();
    }

    public function pluckData()
    {
        return $this->companiesModel->pluckData();
    }

    public function loadCompaniesByCreatedAt()
    {
        return $this->companiesModel->getCompaniesSortedByCreatedAt();
    }

    public function loadCountCompanies()
    {
        return $this->companiesModel->countCompanies();
    }

    public function loadDeactivatedCompanies()
    {
        return $this->companiesModel->getDeactivated();
    }

    public function loadCompaniesInLatestMonth()
    {
        return $this->companiesModel->getCompaniesInLatestMonth();
    }
}
