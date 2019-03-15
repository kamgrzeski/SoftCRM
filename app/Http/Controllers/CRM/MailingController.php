<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Services\MailingService;
use App\Services\SystemLogService;
use App\Traits\Language;
use View;
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
        $this->mailingService = new MailingService();
    }

    public function index()
    {
        $clientEmails = $this->mailingService->getClientMails();

        return View::make('crm.mailing.index')->with(
            [
            'clientEmails' => $clientEmails
            ]
        );
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
