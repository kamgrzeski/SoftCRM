<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Request;

class SystemLogs extends Model
{
    protected $table = 'systemlogs';

    public $ip = null;

    public function __construct()
    {
        $hostName = Request::getHttpHost();

        if (strpos($hostName, 'localhost') != 0) {
            $this->ip = Request::ip();
        } else {
            $this->ip = '212.182.97.186';
        }

//        $this->ip = '212.182.97.186';
    }

    /**
     * @param $actions
     * @param $statusCode
     * @return bool
     */
    public function insertRow($actions, $statusCode)
    {
        $userInformation = $this->getUserInformation();

        return SystemLogs::insert(
            [
                'user_id' => Auth::id(),
                'actions' => $actions,
                'status_code' => $statusCode,
                'date' => Carbon::now(),
                'ip_address' => $userInformation['geoplugin_request'],
                'city' => $userInformation['geoplugin_city'],
                'country' => $userInformation['geoplugin_countryName']
            ]
        );
    }

    /**
     * @return mixed
     */
    public function getUserInformation()
    {
        $geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$this->ip"));

        return $geo;
    }

    /**
     * @return int
     */
    public static function countRows()
    {
        return SystemLogs::all()->count();
    }


}
