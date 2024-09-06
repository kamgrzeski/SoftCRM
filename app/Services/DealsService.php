<?php

namespace App\Services;

use App\Models\DealsModel;
use App\Models\DealsTermsModel;
use Barryvdh\DomPDF\Facade as PDF;

class DealsService
{
    private DealsModel $dealsModel;

    public function __construct()
    {
        $this->dealsModel = new DealsModel();
    }

    public function loadPaginate()
    {
        return $this->dealsModel->getPaginate();
    }

    public function loadCountDeals()
    {
        return $this->dealsModel->countDeals();
    }

    public function loadDeactivatedDeals()
    {
        return $this->dealsModel->getDeactivated();
    }

    public function loadDealsInLatestMonth()
    {
        return $this->dealsModel->getDealsInLatestMonth();
    }

    public function loadGenerateDealTermsInPDF(DealsTermsModel $dealTerm, DealsModel $deal)
    {
        $data = [
            'body' => $dealTerm->body
        ];

        $pdf = PDF::loadView('crm.deals.terms-pdf', $data);

        return $pdf->download($deal->name . '.pdf');
    }
}
