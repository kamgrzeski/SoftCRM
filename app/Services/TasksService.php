<?php

namespace App\Services;

use App\Models\Language;
use App\Models\TasksModel;

class TasksService
{
    private $language;
    private $tasksModel;
    private $systemLogs;

    public function __construct()
    {
        $this->language = new Language();
        $this->tasksModel = new TasksModel();
        $this->systemLogs = new SystemLogService();
    }
}