<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\ClientsModel;
use App\Models\MailingModel;
use App\Services\MailingService;
use App\Services\SystemLogService;
use App\Traits\Language;
use View;
use Request;
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

    public function index()
    {
        $clientEmails = ClientsModel::All();
        return View::make('crm.mailing.index')->with([
            'clientEmails' => $clientEmails]);
    }

    public function search()
    {
        return true; // TODO
    }

    public function sendEmailToThisEmailAddress($allInputs)
    {
        $this->mailingService->loadAdminPanel($allInputs);
    }
}
