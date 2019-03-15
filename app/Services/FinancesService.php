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

    public function getFinances()
    {
        return $this->financesModel::all()->sortByDesc('created_at');
    }

    public function getPagination()
    {
        return $this->financesModel::paginate(Config::get('crm_settings.pagination_size'));
    }

    public function execute($allInputs)
    {
        return $this->financesModel->insertRow($allInputs);
    }

    public function getFinance(int $id)
    {
        return $this->financesModel::find($id);
    }

    public function update(int $id, $allInputs)
    {
        return $this->financesModel->updateRow($id, $allInputs);
    }

    public function loadIsActiveFunction($id, $value)
    {
        return $this->financesModel->setActive($id, $value);
    }

    public function pluckCompanies()
    {
        return $this->financesModel->getPluckCompanies();
    }
}