<?php

namespace App\Services;

use App\Models\ProductsModel;
use App\Traits\Language;

class ProductsService
{
    use Language;

    private ProductsModel $productsModel;

    public function __construct()
    {
        $this->productsModel = new ProductsModel();
    }

    public function loadProducts()
    {
        return $this->productsModel->getProducts();
    }

    public function loadPagination()
    {
        return $this->productsModel->getPaginate();
    }

    public function loadProductsByCreatedAt()
    {
        return $this->productsModel->getProductsByCreatedAt();
    }

    public function loadCountProducts()
    {
        return $this->productsModel->countProducts();
    }
}
