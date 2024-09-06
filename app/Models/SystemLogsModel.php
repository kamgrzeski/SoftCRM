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

    public $timestamps = false;

    public function __construct()
    {
        parent::__construct();

        $hostName = Request::getHttpHost();

        if (strpos($hostName, 'localhost') != 0) {
            $this->ip = Request::ip();
        }
    }

    public function countRows(): int
    {
        return $this->all()->count();
    }
}
