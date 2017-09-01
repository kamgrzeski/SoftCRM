<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Language;
use Axdlee\Config\Rewrite;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use View;

class SettingsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

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

        $writeConfig = new Rewrite;
        $writeConfig->toFile(base_path() .'/config/crm_settings.php', [
            'pagination_size' => $getAllInputFromRequest['pagination_size']
        ]);

        return Redirect::back()->with('message_success', Language::getMessage('messages.SuccessSettingsUpdate'));
    }
}
