<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class SystemLogsModel extends Model
{
    use SoftDeletes;

    protected $table = 'system_logs';

    public function getCountLogs()
    {
        return $this->all()->count();
    }

    public function getSystemLogs()
    {
        return $this->all();
    }

    public function storeSystemLogs($actions, $statusCode)
    {
        $userInformation = $this->getUserInformation();

        self::insert(
            [
                'user_id' => Auth::id() ?? 1,
                'actions' => $actions,
                'status_code' => $statusCode,
                'date' => Carbon::now(),
                'ip_address' => $userInformation['geoplugin_request'],
                'city' => $userInformation['geoplugin_city'],
                'country' => $userInformation['geoplugin_countryName']
            ]
        );
    }

    public function getUserInformation()
    {
        $geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$this->ip"));

        return $geo;
    }
}