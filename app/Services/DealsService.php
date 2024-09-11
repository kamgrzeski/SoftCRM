<?php

namespace App\Services;

use App\Models\DealsModel;
use App\Models\DealsTermsModel;
use App\Queries\DealsQueries;
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
        $dealsInLatestMonth = DealsQueries::getDealsInLatestMonth();
        $allDeals = DealsQueries::countAll();

        return ($allDeals / 100) * count($dealsInLatestMonth);
    }

    /**
     * Generate a PDF of deal terms.
     *
     * @param DealsTermsModel $dealTerm The deal terms to be included in the PDF.
     * @param DealsModel $deal The deal associated with the terms.
     * @return \Illuminate\Http\Response
     */
    public function loadGenerateDealTermsInPDF(DealsTermsModel $dealTerm, DealsModel $deal): \Illuminate\Http\Response
    {
        $data = [
            'body' => $dealTerm->body
        ];

        $pdf = PDF::loadView('crm.deals.terms_pdf', $data);

        return $pdf->download($deal->name . '.pdf');
    }
}
