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
     * Load all companies, optionally for creating a form.
     *
     * @param bool $createForm Whether to load companies for creating a form.
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function loadCompanies(bool $createForm = false)
    {
        return CompaniesQueries::getAll($createForm);
    }

    /**
     * Load paginated list of companies.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function loadPagination(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return CompaniesQueries::getPaginate();
    }

    /**
     * Load companies sorted by creation date.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function loadCompaniesByCreatedAt(): \Illuminate\Database\Eloquent\Collection
    {
        return CompaniesQueries::getCompaniesSortedByCreatedAt();
    }

    /**
     * Load the count of all companies.
     *
     * @return int
     */
    public function loadCountCompanies(): int
    {
        return CompaniesQueries::countAll();
    }

    /**
     * Load the list of deactivated companies.
     *
     * @return int
     */
    public function loadDeactivatedCompanies(): int
    {
        return CompaniesQueries::getDeactivated();
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
