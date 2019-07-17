<?php

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

    public function loadCountFinances()
    {
        return $this->financesModel->getCountFinances();
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
}