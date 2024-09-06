<?php

namespace App\Services;

use App\Models\DealsModel;
use App\Models\DealsTermsModel;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;

class DealsService
{
    private DealsModel $dealsModel;
    private DealsTermsModel $dealsTermsModel;

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
        return $this->dealsModel->getAll();
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
        return $this->dealsModel->getDealsInLatestMonth();
    }

    public function loadStoreDealTerms(array $validatedData)
    {
        return $this->dealsTermsModel->storeDealTerms($validatedData);
    }

    public function loadDealsTerms(DealsModel $deal)
    {
        $query = $deal->dealTerms;

        foreach($query as $key => $value) {
            $query[$key]['formattedDate'] = Carbon::parse($value['created_at'])->format('d M, Y');
        }

        return $query;
    }

    public function loadGenerateDealTermsInPDF(int $termId, int $dealId)
    {
        $data = [
            'body' => $this->dealsTermsModel->getTermsBody($termId)
        ];

        $dealName = $this->dealsModel->getName($dealId);

        $pdf = PDF::loadView('crm.deals.terms-pdf', $data);

        return $pdf->download($dealName . '.pdf');
    }

    public function loadDeleteTerm(int $termId)
    {
        return $this->dealsTermsModel->deleteTerm($termId);
    }

    public function countDealTerms(int $dealId)
    {
        return $this->dealsTermsModel->countAssignedDealTerms($dealId);
    }

    public function loadCountAssignedDeals(int $companiesId)
    {
        return $this->dealsModel->getAssignedDealsForCompanies($companiesId);
    }
}
