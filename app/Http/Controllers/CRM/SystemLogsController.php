<?php

namespace App\Http\Controllers\CRM;

use App\SystemLogs;
use App\Http\Controllers\Controller;

class SystemLogsController extends Controller
{
    public static function insertSystemLogs($actions)
    {
        if(SystemLogs::insertRow($actions)) {
            return true;
        }
    }
}
