<?php
/**
 * Created by PhpStorm.
 * User: kami
 * Date: 16.03.2018
 * Time: 13:59
 */

namespace App\Services;

use App\Models\FinancesModel;
use Config;

class FinancesService
{
    private $financesModel;

    public function __construct()
    {
        $this->financesModel = new FinancesModel();
    }

    public function execute($requestedData)
    {
        return $this->financesModel->storeFinance($requestedData);
    }

    public function update(int $financeId, $requestedData)
    {
        return $this->financesModel->updateFinance($financeId, $requestedData);
    }

    public function calculateNetAndVatByGivenGross($gross)
    {
        $getTaxValueFromConfig = Config::get('crm_settings.invoice_tax')  / 100;
        $getGrossValueFromInput = $gross;

        $vat = $getGrossValueFromInput * $getTaxValueFromConfig;

        $net = $getGrossValueFromInput - $vat;

        return $result = [
            'net' => $net,
            'vat' => $vat,
        ];
    }

    public function loadFinances()
    {
        return $this->financesModel->getFinancesSortedByCreatedAt();
    }

    public function loadPagination()
    {
        return $this->financesModel->getPaginate();
    }

    public function loadFinance(int $financeId)
    {
        return $this->financesModel::find($financeId);
    }

    public function loadIsActiveFunction($financeId, $value)
    {
        return $this->financesModel->setActive($financeId, $value);
    }

    public function pluckCompanies()
    {
        return $this->financesModel->getPluckCompanies();
    }

    public function loadDataAndPagination()
    {
        $dataOfFinances = [
            'finances' => $this->loadFinances(),
            'financesPaginate' => $this->loadPagination()
        ];

        return $dataOfFinances;
    }

    public function loadCountFinances()
    {
        return $this->financesModel->countFinances() ? : 0;
    }
}