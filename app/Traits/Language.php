<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\App;

trait Language
{
    public static function getMessage($message)
    {
        if (App::isLocale('en')) {
            return __($message);
        }
    }
}