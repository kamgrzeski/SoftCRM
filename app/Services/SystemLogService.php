<?php

namespace App\Services;

use App\Models\SystemLogsModel;

class SystemLogService
{
    const successCode = 201;

    private SystemLogsModel $systemLogsModel;

    public function __construct()
    {
        $this->systemLogsModel = new SystemLogsModel();
    }

    public function loadCountLogs()
    {
        return $this->systemLogsModel->countRows();
    }
}
