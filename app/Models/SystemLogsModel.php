<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Request;

class SystemLogsModel extends Model
{
    protected $table = 'systemlogs';

    public $ip = null;

    public function __construct()
    {
        parent::__construct();

        $hostName = Request::getHttpHost();

        if (strpos($hostName, 'localhost') != 0) {
            $this->ip = Request::ip();
        } else {
            $this->ip = '66.249.69.115'; // googlebot
        }
    }

    public function insertSystemLog($actions, int $statusCode, int $adminId)
    {
        $userInformation = $this->getUserInformation();

        self::insert(
            [
                'user_id' => Auth::id(),
                'actions' => $actions,
                'status_code' => $statusCode,
                'date' => Carbon::now(),
                'ip_address' => $userInformation['geoplugin_request'],
                'city' => $userInformation['geoplugin_city'],
                'country' => $userInformation['geoplugin_countryName'],
                'admin_id' => 1 ?? $adminId
            ]
        );
    }

    public function getUserInformation()
    {
        $geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$this->ip"));

        return $geo;
    }

    public function countRows()
    {
        return self::all()->count();
    }
}
