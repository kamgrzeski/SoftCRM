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
        $this->systemLogsModel = new SystemLogsModel();
    }

    public function insertSystemLogs($actions, $statusCode)
    {
        return $this->systemLogsModel->insertRow($actions, $statusCode);
    }
}