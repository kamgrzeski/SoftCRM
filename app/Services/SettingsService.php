<?php
/**
 * Created by PhpStorm.
 * User: kamilgrzechulski
 * Date: 30.07.2018
 * Time: 09:20
 */

namespace App\Services;

use App\Models\SettingsModel;
use Config;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;

class SettingsService
{
    private $settingsModel;

    public function __construct()
    {
        $this->settingsModel = new SettingsModel();
    }

    public function saveEnvData($RollbarToken)
    {
        DotenvEditor::setKey('ROLLBAR_TOKEN', $RollbarToken);
        DotenvEditor::save();
    }
}