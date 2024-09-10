<?php

namespace App\Services;

use App\Queries\SalesQueries;

/**
 * Class SalesService
 *
 * Service class for handling operations related to the SalesModel.
 */
class SalesService
{
    /**
     * Load sales sorted by creation date.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function loadSales(): \Illuminate\Database\Eloquent\Collection
    {
        return SalesQueries::getSalesSortedByCreatedAt();
    }

    /**
     * Load paginated list of sales.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function loadPaginate(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return SalesQueries::getPaginate();
    }

    /**
     * Load the count of all sales.
     *
     * @return int
     */
    public function loadCountSales(): int
    {
        return SalesQueries::countAll();
    }
}
