<?php

namespace App\Traits;

use Illuminate\Support\Facades\App;

trait Language
{
    public function getMessage($message)
    {
        if (App::isLocale('en')) {
            return __($message);
        } else {
            throw new Exception('Undefinded locale type!');
        }
    }
}