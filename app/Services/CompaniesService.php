<?php

namespace App\Services;

use App\Models\CompaniesModel;
use App\Models\DealsModel;

class CompaniesService
{
    private $companiesModel;

    public function __construct()
    {
        $this->companiesModel = new CompaniesModel();
    }

    public function execute(array $requestedData, int $adminId)
    {
        return $this->companiesModel->storeCompanie($requestedData, $adminId);
    }

    public function update(int $companiesId, array $requestedData)
    {
        return $this->companiesModel->updateCompanie($companiesId, $requestedData);
    }

    public function loadCompanies()
    {
        return $this->companiesModel::all()->sortByDesc('created_at');
    }

    public function loadPagination()
    {
        return $this->companiesModel->getPaginate();
    }

    public function pluckData()
    {
        return $this->companiesModel::pluck('name', 'id');
    }

    public function loadCompanie(int $companiesId)
    {
        return $this->companiesModel::find($companiesId);
    }

    public function loadCountAssignedDeals(int $companiesId)
    {
        return DealsModel::where('companies_id', $companiesId)->get()->count();
    }

    public function loadSetActive(int $companiesId, bool $value)
    {
        return $this->companiesModel->setActive($companiesId, $value);
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
        return $this->companiesModel->getCompaniesInLatestMonth() . '%' ? : '0.00%';
    }
}