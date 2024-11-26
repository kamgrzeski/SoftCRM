<?php

namespace App\Services;

use App\Models\Deal;
use App\Models\DealTerm;
use App\Queries\DealQueries;
use Barryvdh\DomPDF\Facade\Pdf;

/**
 * Class DealsService
 *
 * Service class for handling operations related to the DealsModel.
 */
class DealsService
{
    /**
     * Load the list of deals added in the latest month.
     *
     * @return int
     */
    public function loadDealsInLatestMonth(): int
    {
        $dealsInLatestMonth = DealQueries::getDealsInLatestMonth();
        $allDeals = DealQueries::countAll();

        return (int) (($dealsInLatestMonth->count() / $allDeals) * 100);
    }

    /**
     * Generate a PDF of deal terms.
     *
     * @param DealTerm $dealTerm The deal terms to be included in the PDF.
     * @param Deal $deal The deal associated with the terms.
     * @return \Illuminate\Http\Response
     */
    public function loadGenerateDealTermsInPDF(DealTerm $dealTerm, Deal $deal): \Illuminate\Http\Response
    {
        $data = ['body' => $dealTerm->body];

        return PDF::loadView('crm.deals.terms.terms_pdf', $data)
            ->download($deal->name . '.pdf');
    }
}
