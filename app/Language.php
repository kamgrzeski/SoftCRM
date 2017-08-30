<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Language extends Model
{
    /**
     * @param $message
     * @return \Illuminate\Contracts\Translation\Translator|string
     */
    public static function getMessage($message)
    {
        if (App::isLocale('en')) {
            return __($message);
        } else {
            throw new Exception('Undefinded locale type!');
        }
    }
}