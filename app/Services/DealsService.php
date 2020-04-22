<?php

namespace App\Services;

use App\Models\DealsModel;
use App\Models\DealsTermsModel;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class DealsService
{
    private $dealsModel;
    private $dealsTermsModel;

    public function __construct()
    {
        $this->dealsModel = new DealsModel();
        $this->dealsTermsModel = new DealsTermsModel();
    }

    public function execute(array $requestedData, int $adminId)
    {
        return $this->dealsModel->storeDeal($requestedData, $adminId);
    }

    public function update(int $dealId, array $requestedData)
    {
        return $this->dealsModel->updateDeal($dealId, $requestedData);
    }

    public function loadDeals()
    {
        return DealsModel::all()->sortBy('created_at');
    }

    public function loadPaginate()
    {
        return $this->dealsModel->getPaginate();
    }

    public function loadDeal(int $dealId)
    {
        return $this->dealsModel->getDeal($dealId);
    }

    public function pluckDeals()
    {
        return $this->dealsModel->getPluckCompanies();
    }

    public function loadSetActive(int $dealId, bool $value)
    {
        return $this->dealsModel->setActive($dealId, $value);
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
        return $this->dealsModel->getDealsInLatestMonth() . '%' ? : '0.00%';
    }

    public function loadStoreDealTerms(array $validatedData)
    {
        return $this->dealsTermsModel->storeDealTerms($validatedData);
    }

    public function loadDealsTerms(int $dealId)
    {
        return $this->dealsTermsModel->getDealTerms($dealId);
    }

    public function loadGenerateDealTermsInPDF(int $termId)
    {
        $data = [
            'body' => $this->dealsTermsModel->getTermsBody($termId)
        ];

        $pdf = PDF::loadView('crm.deals.terms-pdf', $data);

        return $pdf->stream('crm.deals.terms-pdf');
    }

    public function loadDeleteTerm(int $termId)
    {
        return $this->dealsTermsModel->deleteTerm($termId);
    }

    public function countDealTerms(int $dealId)
    {
        return $this->dealsTermsModel->countAssignedDealTerms($dealId);
    }
}