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

    /**
     * @param $rulesType
     * @return array
     */
    public static function getRules($rulesType)
    {
        switch ($rulesType) {
            case 'STORE':
                return [
                    'name' => 'required',
                    'tax_number' => 'required|integer',
                    'city' => 'required',
                    'billing_address' => 'required',
                    'country' => 'required',
                    'postal_code' => 'required',
                    'employees_size' => 'required|integer',
                    'fax' => 'required',
                    'description' => 'required',
                    'phone' => 'required',
                    'client_id' => 'required',
                ];
        }
    }

    public function loadCompanie(int $id)
    {
        return $this->companiesModel::find($id);
    }

    public function loadSearch($getValueInput)
    {
        return count($this->companiesModel::trySearchCompaniesByValue('name', $getValueInput, 10));
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

    public function loadSetActiveFunction($id, $value)
    {
        return $this->companiesModel->setActive($id, $value);
    }

    public function loadCompaniesByCreatedAt()
    {
        return $this->companiesModel->getCompaniesSortedByCreatedAt();
    }
}