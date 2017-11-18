<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Language;
use App\Settings;
use Axdlee\Config\Rewrite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use View;
use Validator;

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
        return view('crm.settings.index')->with($input);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $getAllInputFromRequest = Input::all();

        $validator = Validator::make($getAllInputFromRequest, Settings::getRules('SETTINGS'));

        if($validator->fails()) {
            return Redirect::back()->with('message_danger', Language::getMessage('messages.ErrorSettingsStore'));
        }

        $writeConfig = new Rewrite;
        $writeConfig->toFile(base_path() . '/config/crm_settings.php', [
            'pagination_size' => $getAllInputFromRequest['pagination_size'],
            'currency' => $getAllInputFromRequest['currency'],
            'priority_size' => $getAllInputFromRequest['priority_size'],
            'invoice_tax' => $getAllInputFromRequest['invoice_tax'],
            'invoice_logo_link' => $getAllInputFromRequest['invoice_logo_link']
        ]);

        SystemLogsController::insertSystemLogs('Settings has been changed.');

        return Redirect::back()->with('message_success', Language::getMessage('messages.SuccessSettingsUpdate'));
    }
}
