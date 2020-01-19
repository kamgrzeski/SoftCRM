<?php

namespace App\Services;

use App\Models\SettingsModel;

class SettingsService
{
    private $settingsModel;

    public function __construct()
    {
        $this->settingsModel = new SettingsModel();
    }

    public function loadUpdateSetting(string $key, string $value) : string
    {
        return $this->settingsModel->updateSetting($key, $value);
    }

    public function loadSettingValue(string $key) : string
    {
        return $this->settingsModel->getSettingValue($key);
    }

    public function loadUpdateSettings(array $validatedData)
    {
        foreach($validatedData as $key => $value) {
            $this->settingsModel->updateSetting($key, $value);
        }

        return true;
    }

    public function loadAllSettings()
    {
        return $this->settingsModel->getAllSettings();
    }

}