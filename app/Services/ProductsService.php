<?php

namespace App\Services;

use App\Models\ProductsModel;

class ProductsService
{
    private $productsModel;

    public function __construct()
    {
        $this->productsModel = new ProductsModel();
    }

    public function loadCountProducts()
    {
        return $this->productsModel->getCountProducts();
    }

    public function loadProducts()
    {
        return $this->productsModel->getProducts();
    }
}