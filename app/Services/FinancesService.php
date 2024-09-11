<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;

/**
 * Class FinancesService
 *
 * Service class for handling operations related to the FinancesModel.
 */
class FinancesService
{
    /**
     * Calculate net and VAT by given gross amount.
     *
     * @param float $gross The gross amount.
     * @return array An array containing the net and VAT amounts.
     */
    public function loadCalculateNetAndVatByGivenGross(float $gross): array
    {
        // TODO: Move this to settings table.
        $getTaxValueFromConfig = Config::get('crm_settings.invoice_tax')  / 100;
        $getGrossValueFromInput = $gross;

        $vat = $getGrossValueFromInput * $getTaxValueFromConfig;

        $net = $getGrossValueFromInput - $vat;

        return [
            'net' => $net,
            'vat' => $vat,
        ];
    }
}
