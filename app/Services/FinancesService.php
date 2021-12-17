<?php

namespace App\Services;

use App\Models\FinancesModel;
use Illuminate\Support\Facades\Config;

class FinancesService
{
    private FinancesModel $financesModel;

    public function __construct()
    {
        $this->financesModel = new FinancesModel();
    }

    public function execute(array $requestedData, int $adminId)
    {
        return $this->financesModel->storeFinance($requestedData, $adminId);
    }

    public function update(int $financeId, array $requestedData)
    {
        return $this->financesModel->updateFinance($financeId, $requestedData);
    }

    public function loadCalculateNetAndVatByGivenGross($gross)
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

    public function loadIsActive(int $financeId, int $value)
    {
        return $this->financesModel->setActive($financeId, $value);
    }

    public function loadCountFinances()
    {
        return $this->financesModel->countFinances();
    }
}
