<?php

namespace App\Services;

use Config;

class SettingsService
{
    public function storeSettings(array $validatedData)
    {
        if (isset($validatedData)) {
            foreach ($validatedData as $key => $data) {
                Config::set('crm_settings.'. $key, $data);
            }
            return true;
        } else {
            return false;
        }
    }

    public function loadConfigData()
    {
        return Config::get('crm_settings');
    }
}