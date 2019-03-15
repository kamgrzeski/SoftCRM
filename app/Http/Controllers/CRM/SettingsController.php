<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingsStoreRequest;
use App\Models\SettingsModel;
use App\Services\HelpersFncService;
use App\Services\SettingsService;
use App\Services\SystemLogService;
use App\Traits\Language;
use Axdlee\Config\Rewrite;
use Illuminate\Support\Facades\Redirect;
use View;
use Validator;
use Config;

class SettingsController extends Controller
{
    use Language;

    private $systemLogs;
    private $settingsModel;
    private $settingsService;
    private $helpersService;

    public function __construct()
    {
        $this->systemLogs = new SystemLogService();
        $this->settingsModel = new SettingsModel();
        $this->settingsService = new SettingsService();
        $this->helpersService = new HelpersFncService();
    }

    public function index()
    {
        $input = config('crm_settings.temp');

        return view('crm.settings.index')->with([
            'input' => $input,
            'logs' => $this->helpersService->formatAllSystemLogs()
        ]);
    }

    public function store(SettingsStoreRequest $request)
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

        $this->systemLogs->insertSystemLogs('SettingsModel has been changed.', $this->systemLogs::successCode);
        return Redirect::back()->with('message_success', $this->getMessage('messages.SuccessSettingsUpdate'));
    }
}
