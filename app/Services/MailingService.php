<?php

namespace App\Services;

use App\Models\Language;
use App\Models\MailingModel;

class MailingService
{
    private $language;
    private $mailingModel;
    private $systemLogs;

    public function __construct()
    {
        $this->language = new Language();
        $this->mailingModel = new MailingModel();
        $this->systemLogs = new SystemLogService();
    }
}