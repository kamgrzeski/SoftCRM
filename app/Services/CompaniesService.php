<?php

namespace App\Services;

use App\Queries\CompaniesQueries;

/**
 * Class CompaniesService
 *
 * Service class for handling operations related to the CompaniesModel.
 */
class CompaniesService
{
    /**
     * Load companies sorted by creation date.
     *
     * @return \Illuminate\Support\Collection
     */
    public function loadCompaniesByCreatedAt(): \Illuminate\Support\Collection
    {
        return CompaniesQueries::getCompaniesSortedByCreatedAt();
    }

    /**
     * Load the list of companies added in the latest month.
     *
     * @return float
     */
    public function loadCompaniesInLatestMonth(): float
    {
        $companiesCount = CompaniesQueries::getCompaniesInLatestMonth();
        $allCompanies = CompaniesQueries::countAll();

        return ($allCompanies / 100) * $companiesCount;
    }
}
