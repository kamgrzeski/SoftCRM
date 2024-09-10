<?php

namespace App\Services;

use App\Models\DealsModel;
use App\Models\DealsTermsModel;
use App\Queries\DealsQueries;
use Barryvdh\DomPDF\Facade as PDF;

/**
 * Class DealsService
 *
 * Service class for handling operations related to the DealsModel.
 */
class DealsService
{
    /**
     * Load paginated list of deals.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function loadPaginate(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return DealsQueries::getPaginate();
    }

    /**
     * Load the count of all deals.
     *
     * @return int
     */
    public function loadCountDeals(): int
    {
        return DealsQueries::countAll();
    }

    /**
     * Load the list of deactivated deals.
     *
     * @returnint
     */
    public function loadDeactivatedDeals(): int
    {
        return DealsQueries::getDeactivated();
    }

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
     * @return \Barryvdh\DomPDF\PDF The generated PDF file.
     */
    public function loadGenerateDealTermsInPDF(DealsTermsModel $dealTerm, DealsModel $deal): \Barryvdh\DomPDF\PDF
    {
        $data = [
            'body' => $dealTerm->body
        ];

        $pdf = PDF::loadView('crm.deals.terms-pdf', $data);

        return $pdf->download($deal->name . '.pdf');
    }
}
