<?php
/**
 * Created by PhpStorm.
 * User: kami
 * Date: 16.03.2018
 * Time: 13:59
 */

namespace App\Services;

use Config;

class financesService
{
    /**
     * @param $gross
     * @return array
     */
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