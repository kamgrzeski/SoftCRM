<?php
/**
 * Created by PhpStorm.
 * User: kami
 * Date: 31.05.2018
 * Time: 17:07
 */

namespace App\Services;

use App\Models\SystemLogsModel;

class SystemLogService
{
    const successCode = 201;

    private $systemLogsModel;

    public function __construct()
    {
        $this->systemLogsServiceModel = new SystemLogsModel();
    }

    public function insertSystemLogs($actions, $statusCode)
    {
        return $this->systemLogsServiceModel->insertRow($actions, $statusCode);
    }

    public function loadCountLogs()
    {
        return $this->systemLogsServiceModel->countRows() ? : 0;
    }
}