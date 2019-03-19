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

    public function execute($requestedData)
    {
        return $this->salesModel->storeTask($requestedData);
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
        return $this->salesModel::find($saleId);
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
        $dataWithSales = [
            'sales' => $this->loadSales(),
            'salesPaginate' => $this->loadPaginate()
        ];

        return $dataWithSales;
    }

    public function loadCountSales()
    {
        return $this->salesModel->countSales() ? : 0;
    }
}