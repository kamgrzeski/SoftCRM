<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingsModel extends Model
{
    protected $table = 'settings';

    public static function getSettingValue(string $key)
    {
        return self::where('key', $key)->get()->last()?->value;
    }
}
