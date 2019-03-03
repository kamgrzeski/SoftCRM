<?php

namespace App\Services;

use App\Models\DealsModel;
use App\Models\Language;

class DealsService
{
    private $language;
    private $dealsModel;
    private $systemLogs;

    public function __construct()
    {
        $this->language = new Language();
        $this->dealsModel = new DealsModel();
        $this->systemLogs = new SystemLogService();
    }
}