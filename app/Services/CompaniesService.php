<?php
/**
 * Created by PhpStorm.
 * User: kamilgrzechulski
 * Date: 30.07.2018
 * Time: 09:20
 */

namespace App\Services;

use App\Models\CompaniesModel;

class CompaniesService
{
    private $companiesModel;

    public function __construct()
    {
        $this->companiesModel = new CompaniesModel();
    }

    public function execute($requestedData)
    {
        return $this->companiesModel->insertCompanie($requestedData);
    }

    public function update(int $companiesId, $requestedData)
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

    /**
     * @return array
     */
    public function loadDataAndPagination()
    {
        $dataOfCompanies = [
            'companies' => $this->loadCompanies(),
            'companiesPaginate' => $this->loadPagination()
        ];

        return $dataOfCompanies;
    }

    public function pluckData()
    {
        return $this->companiesModel::pluck('name', 'id');
    }

    public function loadCompanie(int $companiesId)
    {
        return $this->companiesModel::find($companiesId);
    }

    public function countAssignedDeals(CompaniesModel $dataOfCompanies)
    {
        return count($dataOfCompanies->deals()->get());
    }

    public function countAssignedFile(CompaniesModel $dataOfCompanies)
    {
        return count($dataOfCompanies->files()->get());
    }

    public function loadSetActive($companiesId, $value)
    {
        return $this->companiesModel->setActive($companiesId, $value);
    }

    public function loadCompaniesByCreatedAt()
    {
        return $this->companiesModel->getCompaniesSortedByCreatedAt();
    }

    public function loadCountCompanies()
    {
        return $this->companiesModel->countCompanies() ? : 0;
    }

    public function loadDeactivatedCompanies()
    {
        return $this->companiesModel->getDeactivated() ? : 0;
    }

    public function loadCompaniesInLatestMonth()
    {
        return $this->companiesModel->getCompaniesInLatestMonth() . '%' ? : '0.00%';
    }
}