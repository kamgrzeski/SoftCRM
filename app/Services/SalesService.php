<?php

namespace App\Services;

use App\Models\ProductsModel;
use App\Models\SalesModel;

class SalesService
{
    private $salesModel;

    public function __construct()
    {
        $this->salesModel = new SalesModel();
    }

    public function execute(array $requestedData, int $adminId)
    {
        return $this->salesModel->storeSale($requestedData, $adminId);
    }

    public function update(int $saleId, array $requestedData)
    {
        return $this->salesModel->updateTask($saleId, $requestedData);
    }

    public function loadSales()
    {
        return $this->salesModel->getSalesSortedByCreatedAt();
    }

    public function loadPaginate()
    {
        return $this->salesModel->getPaginate();
    }

    public function loadSale(int $saleId)
    {
        return $this->salesModel->getSale($saleId);
    }

    public function loadIsActiveFunction(int $saleId, int $value)
    {
        return $this->salesModel->setActive($saleId, $value);
    }

    public function loadProducts()
    {
        return ProductsModel::pluck('name', 'id');
    }

    public function loadCountSales()
    {
        return $this->salesModel->countSales();
    }
}