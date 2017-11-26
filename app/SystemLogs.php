<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Request;

class SystemLogs extends Model
{
    protected $table = 'systemlogs';

    public static function insertRow($actions)
    {
        return SystemLogs::insert(
            [
                'user_id' => Auth::id(),
                'actions' => $actions,
                'date' => Carbon::now(),
                'ip_address' => Request::ip()
            ]
        );
    }
}
