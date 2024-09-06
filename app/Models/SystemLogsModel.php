<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Request;

class SystemLogsModel extends Model
{
    protected $table = 'systemlogs';

    public string $ip = '66.249.69.115'; // googlebot

    public function __construct()
    {
        parent::__construct();

        $hostName = Request::getHttpHost();

        if (strpos($hostName, 'localhost') != 0) {
            $this->ip = Request::ip();
        }
    }

    public function insertSystemLog($actions, int $statusCode, int $adminId = 1)
    {
        $userInformation = $this->getUserInformation();

        return self::insert(
            [
                'user_id' => auth()->id(),
                'actions' => $actions,
                'status_code' => $statusCode,
                'date' => Carbon::now(),
                'ip_address' => $userInformation['geoplugin_request'],
                'city' => $userInformation['geoplugin_city'],
                'country' => $userInformation['geoplugin_countryName'],
                'admin_id' => $adminId
            ]
        );
    }

    public function getUserInformation()
    {
        return unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$this->ip"));
    }

    public function countRows() : int
    {
        return $this->all()->count();
    }
}
