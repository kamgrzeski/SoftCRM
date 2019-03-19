<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingsStoreRequest;
use Axdlee\Config\Rewrite;
use Illuminate\Support\Facades\Redirect;
use View;
use Validator;
use Config;

class SettingsController extends Controller
{
    public function processListOfSettings()
    {
        $collectDataForView = array_merge($this->collectedData(), ['input' => config('crm_settings.temp')], ['logs' => $this->helpersFncService->formatAllSystemLogs()]);

        return view('crm.settings.index')->with($collectDataForView);
    }

    public function processCreateSettings(SettingsStoreRequest $request)
    {
        $validatedData = $request->validated();

        $writeConfig = new Rewrite;
        $writeConfig->toFile(base_path() . '/config/crm_settings.php', [
            'pagination_size' => $validatedData['pagination_size'],
            'currency' => $validatedData['currency'],
            'priority_size' => $validatedData['priority_size'],
            'invoice_tax' => $validatedData['invoice_tax'],
            'invoice_logo_link' => $validatedData['invoice_logo_link'],
            'rollbar_token' => $validatedData['rollbar_token'],
            'loading_circle' => $validatedData['loading_circle'],
            'stats' => $validatedData['stats']
        ]);

        $this->settingsService->saveEnvData($validatedData['rollbar_token']);

        $this->systemLogsService->insertSystemLogs('SettingsModel has been changed.', $this->systemLogsService::successCode);
        return Redirect::back()->with('message_success', $this->getMessage('messages.SuccessSettingsUpdate'));
    }
}
