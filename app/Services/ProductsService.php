<?php

namespace App\Services;

use App\Queries\ProductsQueries;
use App\Traits\Language;

/**
 * Class ProductsService
 *
 * Service class for handling operations related to the ProductsModel.
 */
class ProductsService
{
    use Language;

    /**
     * Load all products.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function loadProducts(): \Illuminate\Database\Eloquent\Collection
    {
        return ProductsQueries::getAll();
    }

    /**
     * Load paginated list of products.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function loadPagination(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return ProductsQueries::getPaginate();
    }

    /**
     * Load products sorted by creation date.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function loadProductsByCreatedAt(): \Illuminate\Database\Eloquent\Collection
    {
        return ProductsQueries::getProductsByCreatedAt();
    }

    /**
     * Load the count of all products.
     *
     * @return int
     */
    public function loadCountProducts(): int
    {
        return ProductsQueries::countAll();
    }
}
