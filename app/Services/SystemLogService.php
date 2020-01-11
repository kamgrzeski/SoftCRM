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

    public function loadInsertSystemLogs(string $actions, int $statusCode, int $adminId)
    {
        return $this->systemLogsModel->insertSystemLog($actions, $statusCode, $adminId);
    }

    public function loadCountLogs()
    {
        return $this->systemLogsModel->countRows();
    }
}