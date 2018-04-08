<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\SettingsModel;
use App\Services\HelpersFncService;
use Axdlee\Config\Rewrite;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use View;
use Validator;
use Config;

class SettingsController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $input = config('crm_settings.temp');

        return view('crm.settings.index')->with([
            'input' => $input,
            'logs' => $this->formatAllSystemLogs()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $getAllInputFromRequest = Input::all();

        $validator = Validator::make($getAllInputFromRequest, SettingsModel::getRules('SETTINGS'));

        if($validator->fails()) {
            return Redirect::back()->with('message_danger', Language::getMessage('messages.ErrorSettingsStore'));
        }

        $writeConfig = new Rewrite;
        $writeConfig->toFile(base_path() . '/config/crm_settings.php', [
            'pagination_size' => $getAllInputFromRequest['pagination_size'],
            'currency' => $getAllInputFromRequest['currency'],
            'priority_size' => $getAllInputFromRequest['priority_size'],
            'invoice_tax' => $getAllInputFromRequest['invoice_tax'],
            'invoice_logo_link' => $getAllInputFromRequest['invoice_logo_link'],
            'rollbar_token' => $getAllInputFromRequest['rollbar_token'],
            'loading_circle' => $getAllInputFromRequest['loading_circle'],
            'stats' => $getAllInputFromRequest['stats']
        ]);

        $envEditor = DotenvEditor::setKey('ROLLBAR_TOKEN', $getAllInputFromRequest['rollbar_token']);
        $envEditor = DotenvEditor::save();

        SystemLogsController::insertSystemLogs('SettingsModel has been changed.', 200);

        return Redirect::back()->with('message_success', Language::getMessage('messages.SuccessSettingsUpdate'));
    }

    public function formatAllSystemLogs()
    {
        $helpers = new HelpersFncService();

        if($helpers) {
            return $helpers->formatAllSystemLogs();
        }

        return false;
    }
}
