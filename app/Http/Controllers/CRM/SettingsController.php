<?php

namespace App\Http\Controllers\CRM;

use App\Enums\SystemEnums;
use App\Http\Controllers\Controller;
use App\Http\Requests\SettingsStoreRequest;
use App\Services\HelpersFncService;
use App\Services\SettingsService;
use App\Services\SystemLogService;
use Illuminate\Support\Facades\Redirect;
use View;

class SettingsController extends Controller
{
    private HelpersFncService $helpersFncService;
    private SettingsService $settingsService;
    private SystemLogService $systemLogsService;

    public function __construct()
    {
        $this->middleware(SystemEnums::middleWareAuth);

        $this->helpersFncService = new HelpersFncService();
        $this->settingsService = new SettingsService();
        $this->systemLogsService = new SystemLogService();
    }

    public function processListOfSettings()
    {
        return view('crm.settings.index')->with(
            [
                'settings' => $this->settingsService->loadAllSettings(),
                'logs' => $this->helpersFncService->formatAllSystemLogs()
            ]
        );
    }

    public function processUpdateSettings(SettingsStoreRequest $request)
    {
        $validatedData = $request->validated();

        if ($this->settingsService->loadUpdateSettings($validatedData)) {
            $this->systemLogsService->loadInsertSystemLogs('SettingsModel has been changed.', $this->systemLogsService::successCode, $this->getAdminId());
            return Redirect::back()->with('message_success', $this->getMessage('messages.SuccessSettingsUpdate'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorSettingsUpdate'));
        }
    }
}
