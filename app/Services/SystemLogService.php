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
    /**
     * @param $actions
     * @param int $statusCode
     * @return bool
     */
    public function insertSystemLogs($actions, $statusCode)
    {
        $logs = new SystemLogsModel();
        if($logs->insertRow($actions, $statusCode)) {
            return true;
        }
    }
}