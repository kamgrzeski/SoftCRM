<?php
/**
 * Created by PhpStorm.
 * User: kamilgrzechulski
 * Date: 30.07.2018
 * Time: 09:20
 */

namespace App\Services;

use App\Models\Language;
use App\Models\SettingsModel;
use Config;
use Jackiedo\DotenvEditor\DotenvEditor;

class SettingsService
{
    private $language;
    private $settingsModel;
    private $systemLogs;

    public function __construct()
    {
        $this->language = new Language();
        $this->settingsModel = new SettingsModel();
        $this->systemLogs = new SystemLogService();
    }

    public function loadRules()
    {
        return $this->settingsModel->getRules('SETTINGS');
    }

    public function saveEnvData($RollbarToken)
    {
        DotenvEditor::setKey('ROLLBAR_TOKEN', $RollbarToken);
        DotenvEditor::save();
    }
}