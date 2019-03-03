<?php

namespace App\Services;

use App\Models\FilesModel;
use App\Models\Language;

class FilesService
{
    private $language;
    private $filesModel;
    private $systemLogs;

    public function __construct()
    {
        $this->language = new Language();
        $this->filesModel = new FilesModel();
        $this->systemLogs = new SystemLogService();
    }
}