<?php

namespace App\Services;

use App\Models\SettingsModel;

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
}
