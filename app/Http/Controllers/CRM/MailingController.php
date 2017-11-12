<?php

namespace App\Http\Controllers\CRM;

use App\Client;
use App\Mailing;
use App\Http\Controllers\Controller;
use App\Language;
use Validator;
use Illuminate\Support\Facades\Input;
use View;
use Request;
Use Illuminate\Support\Facades\Redirect;
use Config;

class MailingController extends Controller
{
    /**
     * @return array
     */
    private function getDataAndPagination()
    {
        $dataWithMailing = [
            'mailing' => Mailing::all(),
            'mailingPaginate' => Mailing::paginate(Config::get('crm_settings.pagination_size'))
        ];

        return $dataWithMailing;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientEmails = Client::All();
        return View::make('crm.mailing.index')->with([
            'clientEmails' => $clientEmails]);
    }


    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function search()
    {
        $getValueInput = Request::input('search');
        $findMailingByValue = count(Mailing::trySearchMailingByValue('full_name', $getValueInput, 10));
        $dataOfMailing = $this->getDataAndPagination();

        if (!$findMailingByValue > 0) {
            return redirect('mailing')->with('message_danger', Language::getMessage('messages.ThereIsNoMailing'));
        } else {
            $dataOfMailing += ['mailing_search' => $findMailingByValue];
            Redirect::to('mailing/search')->with('message_success', 'Find ' . $findMailingByValue . ' mailing!');
        }

        return View::make('crm.mailing.index')->with($dataOfMailing);
    }

    public function sendEmailToThisEmailAddress($allInputs)
    {
        Mailing::addEmailToMailManager($allInputs);
    }
}
