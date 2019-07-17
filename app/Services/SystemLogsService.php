<?php

namespace App\Services;

use App\Models\SystemLogsModel;

class SystemLogsService
{
    private $systemLogsModel;

    public function __construct()
    {
        $this->systemLogsModel = new SystemLogsModel();
    }

    public function loadCountLogs()
    {
        return $this->systemLogsModel->getCountLogs();
    }

    public function loadSystemLogs()
    {
        return $this->systemLogsModel->getSystemLogs();
    }

    public function insertSystemLogs($actions, $statusCode)
    {
        return $this->systemLogsModel->storeSystemLogs($actions, $statusCode);
    }
}