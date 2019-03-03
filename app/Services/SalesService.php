<?php

namespace App\Services;

use App\Models\Language;
use App\Models\SalesModel;

class SalesService
{
    private $language;
    private $salesModel;
    private $systemLogs;

    public function __construct()
    {
        $this->language = new Language();
        $this->salesModel = new SalesModel();
        $this->systemLogs = new SystemLogService();
    }
}