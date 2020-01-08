<?php

namespace App\Services;

use App\Models\SystemLogsModel;

class SystemLogService
{
    const successCode = 201;

    private $systemLogsModel;

    public function __construct()
    {
        $this->systemLogsModel = new SystemLogsModel();
    }

    public function insertSystemLogs($actions, $statusCode)
    {
        return $this->systemLogsModel->insertRow($actions, $statusCode);
    }

    public function loadCountLogs()
    {
        return $this->systemLogsModel->countRows();
    }
}