<?php

namespace App\Services;

use App\Models\Language;
use App\Models\ProductsModel;

class ProductsService
{
    private $language;
    private $productsModel;
    private $systemLogs;

    public function __construct()
    {
        $this->language = new Language();
        $this->productsModel = new ProductsModel();
        $this->systemLogs = new SystemLogService();
    }
}