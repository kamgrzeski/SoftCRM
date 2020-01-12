<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingsStoreRequest;
use App\Services\HelpersFncService;
use App\Services\SettingsService;
use App\Services\SystemLogService;
use Illuminate\Support\Facades\Redirect;
use View;
use Validator;
use Config;

class SettingsController extends Controller
{
    private $helpersFncService;
    private $settingsService;
    private $systemLogsService;

    public function __construct()
    {
        $this->middleware('auth');

        $this->helpersFncService = new HelpersFncService();
        $this->settingsService = new SettingsService();
        $this->systemLogsService = new SystemLogService();
    }

    public function processListOfSettings()
    {
        return view('crm.settings.index')->with(
            [
                'input' => config('crm_settings.temp'),
                'logs' => $this->helpersFncService->formatAllSystemLogs()
            ]
        );
    }

    public function processStoreSettings(SettingsStoreRequest $request)
    {
        $validatedData = $request->validated();

        Config::set('crm_settings', ['pagination_size' => $validatedData['pagination_size'],
            'currency' => $validatedData['currency'],
            'priority_size' => $validatedData['priority_size'],
            'invoice_tax' => $validatedData['invoice_tax'],
            'invoice_logo_link' => $validatedData['invoice_logo_link'],
            'stats' => $validatedData['stats']]);


        $this->settingsService->saveEnvData($validatedData['rollbar_token']);

        $this->systemLogsService->loadInsertSystemLogs('SettingsModel has been changed.', $this->systemLogsService::successCode, $this->getAdminId());
        return Redirect::back()->with('message_success', $this->getMessage('messages.SuccessSettingsUpdate'));
    }
}
