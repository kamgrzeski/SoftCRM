<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\ClientsModel;
use App\Models\MailingModel;
use App\Services\MailingService;
use App\Services\SystemLogService;
use App\Traits\Language;
use Validator;
use View;
use Request;
Use Illuminate\Support\Facades\Redirect;
use Config;

class MailingController extends Controller
{
    use Language;

    private $systemLogs;
    private $mailingModel;
    private $mailingService;

    public function __construct()
    {
        $this->systemLogs = new SystemLogService();
        $this->mailingModel = new MailingModel();
        $this->mailingService = new MailingService();
    }

    /**
     * @return array
     */
    private function getDataAndPagination()
    {
        $dataWithMailing = [
            'mailing' => $this->mailingService->getMailing(),
            'mailingPaginate' => $this->mailingService->getPagination()
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
        $findMailingByValue = $this->mailingService->loadSearch($getValueInput);
        $dataOfMailing = $this->getDataAndPagination();

        if (!$findMailingByValue > 0) {
            return redirect('mailing')->with('message_danger', $this->getMessage('messages.ThereIsNoMailing'));
        } else {
            $dataOfMailing += ['mailing_search' => $findMailingByValue];
            Redirect::to('mailing/search')->with('message_success', 'Find ' . $findMailingByValue . ' mailing!');
        }

        return View::make('crm.mailing.index')->with($dataOfMailing);
    }

    public function sendEmailToThisEmailAddress($allInputs)
    {
        $this->mailingService->loadAdminPanel($allInputs);
    }
}
