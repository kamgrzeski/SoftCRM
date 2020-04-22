<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingsModel extends Model
{
    protected $table = 'settings';

    public function updateSetting(string $key, string $value) : int
    {
        return $this->where('key', $key)->update(
            [
                'value' => $value,
                'updated_at' => now()
            ]);
    }

    public static function getSettingValue(string $key)
    {
        $query = self::where('key', $key)->get()->last();

        if($query) {
            return $query->value;
        } else {
            new \Exception('invalid key');
        }
    }

    public function getAllSettings()
    {
        $allSettings = $this->all()->toArray();
        $container = [];

        foreach($allSettings as $key => $setting) {
            $container[$setting['key']] = $setting['value'];
        }

        return $container;
    }
}
