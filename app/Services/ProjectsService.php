<?php

namespace App\Services;

use App\Models\Language;
use App\Models\ProjectsModel;

class ProjectsService
{
    private $language;
    private $projectsModel;
    private $systemLogs;

    public function __construct()
    {
        $this->language = new Language();
        $this->projectsModel = new ProjectsModel();
        $this->systemLogs = new SystemLogService();
    }
}