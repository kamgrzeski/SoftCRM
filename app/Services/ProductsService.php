<?php

namespace App\Services;

use App\Models\ProductsModel;
use App\Traits\Language;
use Config;

class ProductsService
{
    use Language;

    private $productsModel;

    public function __construct()
    {
        $this->productsModel = new ProductsModel();
    }

    public function execute($requestedData)
    {
        return $this->productsModel->storeProduct($requestedData);
    }

    public function update(int $productId, $requestedData)
    {
        return $this->productsModel->updateProduct($productId, $requestedData);
    }

    public function loadProducts()
    {
        return $this->productsModel->getProducts();
    }

    public function loadPagination()
    {
        return $this->productsModel->getPaginate();
    }
    public function loadProduct(int $productId)
    {
        return $this->productsModel->getProduct($productId);
    }

    public function loadIsActiveFunction($productId, $value)
    {
        return $this->productsModel->setActive($productId, $value);
    }

    public function loadProductsByCreatedAt()
    {
        return $this->productsModel->getProductsByCreatedAt();
    }

    public function loadDataAndPagination()
    {
        $dataWithProducts = [
            'products' => $this->loadProducts(),
            'productsPaginate' => $this->loadPagination()
        ];

        return $dataWithProducts;
    }

    public function checkIfProductHaveAssignedSale(int $productId)
    {
        $product = $this->productsModel->findClientByGivenClientId($productId);

        $countSales = $product->sales()->count();

        if ($countSales > 0) {
            return $this->getMessage('messages.firstDeleteSales');
        }
    }

    public function loadCountProducts()
    {
        return $this->productsModel->countProducts() ? : 0;
    }
}