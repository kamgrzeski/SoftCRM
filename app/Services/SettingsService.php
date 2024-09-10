<?php

namespace App\Services;

use App\Models\SettingsModel;
use App\Queries\SettingsQueries;

/**
 * Class SettingsService
 *
 * Service class for handling operations related to the SettingsModel.
 */
class SettingsService
{
    private SettingsModel $settingsModel;

    /**
     * SettingsService constructor.
     *
     * Initializes a new instance of the SettingsModel.
     */
    public function __construct()
    {
        $this->settingsModel = new SettingsModel();
    }

    /**
     * Load the value of a specific setting by key.
     *
     * @param string $key The key of the setting to retrieve.
     * @return string The value of the setting.
     */
    public function loadSettingValue(string $key) : string
    {
        return $this->settingsModel->getSettingValue($key);
    }

    /**
     * Load all settings as an associative array.
     *
     * @return array An associative array of all settings, with keys as setting keys and values as setting values.
     */
    public function loadAllSettings(): array
    {
        $allSettings = SettingsQueries::getAll();

        $container = [];

        foreach($allSettings as $setting) {
            $container[$setting['key']] = $setting['value'];
        }

        return $container;
    }
}
