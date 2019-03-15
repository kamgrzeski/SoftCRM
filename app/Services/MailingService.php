<?php

namespace App\Services;

use App\Models\MailingModel;

class MailingService
{
    private $mailingModel;

    public function __construct()
    {
        $this->mailingModel = new MailingModel();
    }

    public function getMailing()
    {
        return MailingModel::all()->sortByDesc('created_at');
    }

    public function getPagination()
    {
        return MailingModel::paginate(Config::get('crm_settings.pagination_size'));
    }

    public function loadAdminPanel($allInputs)
    {
        return $this->mailingModel::addEmailToMailManager($allInputs);
    }
}