<?php

namespace App\Services;

use App\Models\DealsModel;

class DealsService
{
    private $dealsModel;

    public function __construct()
    {
        $this->dealsModel = new DealsModel();
    }

    public function loadCountDeals()
    {
        return $this->dealsModel->getCountDeals();
    }

    public function loadDeactivatedDeals()
    {
        return $this->dealsModel->getCountOfDeactivatedDeals();
    }

    public function loadDealsInLatestMonth()
    {
        return $this->dealsModel->getCountOfDealsInLatestMonth();
    }

    public function loadDealsList()
    {
        return $this->dealsModel->getDeals();
    }

    public function loadDealDetails($dealId)
    {
        $dealDetails = $this->dealsModel->getDealDetails($dealId);

        if($dealDetails == null) {
            return false;
        }

        return [
            'dealDetails' => $dealDetails,
        ];
    }

    public function update($validatedData, int $clientId)
    {
        $this->dealsModel = DealsModel::find($clientId);

        if (isset($this->dealsModel)) {
            if (isset($validatedData->name))
                $this->dealsModel->name = $validatedData->name;

            if (isset($validatedData->start_time) && count($validatedData->start_time) != 0)
                $this->dealsModel->start_time = $validatedData->start_time;

            if (isset($validatedData->end_time) && count($validatedData->end_time) != 0)
                $this->dealsModel->end_time = $validatedData->end_time;

            if (isset($validatedData->companies_id) && count($validatedData->companies_id) != 0)
                $this->dealsModel->companies_id = $validatedData->companies_id;

            if ($this->dealsModel->save()) {
                return $this->dealsModel;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function loadDealDelete($dealId)
    {
        return $this->dealsModel->deleteDeal($dealId);
    }

    public function setIsActive(int $dealId, $value)
    {
        $dealsModel = DealsModel::find($dealId);

        $dealsModel->is_active = $value == 1 ? false : true;

        if ($dealsModel->save()) {
            return $dealsModel;
        } else {
            return false;
        }
    }
}