<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingsStoreRequest;
use App\Services\SettingsService;
use App\Services\SystemLogsService;
use Config;
use Illuminate\Http\{JsonResponse};

class SettingsController extends Controller
{
    private $systemLogsService;
    private $settingsService;

    public function __construct()
    {
        parent::__construct();

        $this->systemLogsService = new SystemLogsService();
        $this->settingsService = new SettingsService();
    }

    public function processListOfSystemLogs() : array
    {
        return [
            'systemLogs' => $this->systemLogsService->loadSystemLogs(),
            'configData' => $this->settingsService->loadConfigData()
        ];
    }

    public function processStoreSettings(SettingsStoreRequest $request) : JsonResponse
    {
        $validatedData = $request->validated();

        if ($this->settingsService->storeSettings($validatedData)) {
            $this->insertSystemLogs('Settings has been changed.', $this->successCode);
            return $this->jsonResponse('You have successfully stored settings!', [], $this->successCode, $this->startTime);
        } else {
            return $this->jsonResponse('Something went wrong while storing settings.', [], $this->unauthorized, $this->startTime);
        }
    }
}
