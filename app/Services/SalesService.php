<?php

namespace App\Services;

use App\Models\SalesModel;

class SalesService
{
    private SalesModel $salesModel;

    public function __construct()
    {
        $this->salesModel = new SalesModel();
    }

    public function loadSales()
    {
        return $this->salesModel->getSalesSortedByCreatedAt();
    }

    public function loadPaginate()
    {
        return $this->salesModel->getPaginate();
    }

    public function loadCountSales()
    {
        return $this->salesModel->countSales();
    }
}
