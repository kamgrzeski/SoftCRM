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

        return [
            'net' => $net,
            'vat' => $vat,
        ];
    }

    public function loadPagination()
    {
        return $this->financesModel->getPaginate();
    }

    public function loadCountFinances()
    {
        return $this->financesModel->countFinances();
    }
}
