<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\SystemLogsModel;

class SystemLogsController extends Controller
{
    /**
     * @param $actions
     * @param int $statusCode
     * @return bool
     */
    public static function insertSystemLogs($actions, $statusCode)
    {
        $logs = new SystemLogsModel();
        if($logs->insertRow($actions, $statusCode)) {
            return true;
        }
    }
}
