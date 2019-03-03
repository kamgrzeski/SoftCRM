<?php

namespace App\Services;

use App\Models\InvoicesModel;
use App\Models\Language;

class InvoicesService
{
    private $language;
    private $invoicesModel;
    private $systemLogs;

    public function __construct()
    {
        $this->language = new Language();
        $this->invoicesModel = new InvoicesModel();
        $this->systemLogs = new SystemLogService();
    }
}