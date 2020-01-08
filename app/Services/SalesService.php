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

    public function execute($requestedData, int $adminId)
    {
        return $this->salesModel->storeSale($requestedData, $adminId);
    }

    public function update($saleId, $requestedData)
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

    public function loadIsActiveFunction($saleId, $value)
    {
        return $this->salesModel->setActive($saleId, $value);
    }

    public function loadProducts()
    {
        return ProductsModel::pluck('name', 'id');
    }

    public function loadDataAndPagination()
    {
        return [
            'sales' => $this->loadSales(),
            'salesPaginate' => $this->loadPaginate()
        ];
    }

    public function loadCountSales()
    {
        return $this->salesModel->countSales();
    }
}