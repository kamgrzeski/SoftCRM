<?php

namespace App\Services;

use App\Models\Language;
use Config;

class ContactsService
{
    private $language;
    private $contactsModel;
    private $systemLogs;

    public function __construct()
    {
        $this->language = new Language();
        $this->contactsModel = new ContactsService();
        $this->systemLogs = new SystemLogService();
    }
}