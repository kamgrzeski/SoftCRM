<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\ClientsModel;
use App\Models\Language;
use App\Models\MailingModel;
use App\Services\MailingService;
use App\Services\SystemLogService;
use Validator;
use View;
use Request;
Use Illuminate\Support\Facades\Redirect;
use Config;

class MailingController extends Controller
{
    private $systemLogs;
    private $language;
    private $mailingModel;
    private $mailingService;

    public function __construct()
    {
        $this->systemLogs = new SystemLogService();
        $this->language = new Language();
        $this->mailingModel = new MailingModel();
        $this->mailingService = new MailingService();
    }

    /**
     * @return array
     */
    private function getDataAndPagination()
    {
        $dataWithMailing = [
            'mailing' => MailingModel::all()->sortByDesc('created_at'),
            'mailingPaginate' => MailingModel::paginate(Config::get('crm_settings.pagination_size'))
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
        $clientEmails = ClientsModel::All();
        return View::make('crm.mailing.index')->with([
            'clientEmails' => $clientEmails]);
    }


    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function search()
    {
        $getValueInput = Request::input('search');
        $findMailingByValue = count($this->mailingModel->trySearchMailingByValue('full_name', $getValueInput, 10));
        $dataOfMailing = $this->getDataAndPagination();

        if (!$findMailingByValue > 0) {
            return redirect('mailing')->with('message_danger', $this->language->getMessage('messages.ThereIsNoMailing'));
        } else {
            $dataOfMailing += ['mailing_search' => $findMailingByValue];
            Redirect::to('mailing/search')->with('message_success', 'Find ' . $findMailingByValue . ' mailing!');
        }

        return View::make('crm.mailing.index')->with($dataOfMailing);
    }

    public function sendEmailToThisEmailAddress($allInputs)
    {
        MailingModel::addEmailToMailManager($allInputs);
    }
}
