<?php

namespace App\Services;

use App\Models\SalesModel;

class SalesService
{
    private $salesModel;

    public function __construct()
    {
        $this->salesModel = new SalesModel();
    }

    public function loadCountSales()
    {
        return $this->salesModel->getCountSales();
    }
}