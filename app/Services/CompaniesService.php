<?php
/**
 * Created by PhpStorm.
 * User: kamilgrzechulski
 * Date: 30.07.2018
 * Time: 09:20
 */

namespace App\Services;

use App\Models\CompaniesModel;
use Config;

class CompaniesService
{
    private $companiesModel;

    public function __construct()
    {
        $this->companiesModel = new CompaniesModel();
    }

    public function loadCompanies()
    {
        return $this->companiesModel::all()->sortByDesc('created_at');
    }

    public function loadPagination()
    {
        return $this->companiesModel::paginate(Config::get('crm_settings.pagination_size'));
    }

    /**
     * @return array
     */
    public function getDataAndPagination()
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

    public function loadCompanie(int $id)
    {
        return $this->companiesModel::find($id);
    }

    public function countAssignedDeals(CompaniesModel $dataOfCompanies)
    {
        return count($dataOfCompanies->deals()->get());
    }

    public function countAssignedFile(CompaniesModel $dataOfCompanies)
    {
        return count($dataOfCompanies->files()->get());
    }

    public function countAssignedInvoice(CompaniesModel $dataOfCompanies)
    {
        return count($dataOfCompanies->invoices()->get());
    }

    public function execute($allInputs)
    {
        return $this->companiesModel->insertRow($allInputs);
    }

    public function update(int $id, $allInputs)
    {
        return $this->companiesModel->updateRow($id, $allInputs);
    }

    public function loadSetActive($id, $value)
    {
        return $this->companiesModel->setActive($id, $value);
    }

    public function loadCompaniesByCreatedAt()
    {
        return $this->companiesModel->getCompaniesSortedByCreatedAt();
    }
}