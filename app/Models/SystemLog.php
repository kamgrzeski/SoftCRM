<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    use HasFactory;

    public string $ip = '66.249.69.115'; // googlebot

    public $timestamps = false;

    public function __construct()
    {
        parent::__construct();

        $hostName = request()->getHttpHost();

        if (strpos($hostName, 'localhost') != 0) {
            $this->ip = request()->ip();
        }
    }
}
