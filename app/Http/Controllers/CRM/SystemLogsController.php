<?php

namespace App\Http\Controllers\CRM;

use App\SystemLogs;
use App\Http\Controllers\Controller;

class SystemLogsController extends Controller
{
    /**
     * @param $actions
     * @param int $statusCode
     * @return bool
     */
    public static function insertSystemLogs($actions, $statusCode)
    {
        $logs = new SystemLogs();
        if($logs->insertRow($actions, $statusCode)) {
            return true;
        }
    }
}
