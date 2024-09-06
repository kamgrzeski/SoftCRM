<?php

namespace App\Http\Controllers\CRM;

use App\Enums\SystemEnums;
use App\Http\Controllers\Controller;
use App\Http\Requests\SettingsStoreRequest;
use App\Jobs\StoreCurrencySearch;
use App\Jobs\UpdateSettingsJob;
use App\Services\HelpersFncService;
use App\Services\SettingsService;
use App\Services\SystemLogService;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Redirect;

class SettingsController extends Controller
{
    use DispatchesJobs;

    private HelpersFncService $helpersFncService;
    private SettingsService $settingsService;
    private SystemLogService $systemLogsService;

    public function __construct(HelpersFncService $helpersFncService, SettingsService $settingsService, SystemLogService $systemLogService)
    {
        $this->middleware(SystemEnums::middleWareAuth);

        $this->helpersFncService = $helpersFncService;
        $this->settingsService = $settingsService;
        $this->systemLogsService = $systemLogService;
    }

    public function processListOfSettings()
    {
        return view('crm.settings.index')->with([
                'settings' => $this->settingsService->loadAllSettings(),
                'logs' => $this->helpersFncService->formatAllSystemLogs(),
                'logsPaginate' => $this->helpersFncService->loadPaginationForLogs()
            ]);
    }

    public function processUpdateSettings(SettingsStoreRequest $request)
    {
        // Validate the incoming request using the SettingsStoreRequest
        $validatedData = $request->validated();

        // Dispatch the UpdateSettingsJob to update the settings
        $this->dispatchSync(new UpdateSettingsJob($validatedData));

        $this->systemLogsService->loadInsertSystemLogs('SettingsModel has been changed.', $this->systemLogsService::successCode, $this->getAdminId());

        // Redirect back with a success message
        return Redirect::back()->with('message_success', $this->getMessage('messages.SuccessSettingsUpdate'));
    }
}
