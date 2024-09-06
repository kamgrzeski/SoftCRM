<?php

namespace App\Services;

use App\Models\AdminModel;

class AdminService
{
    private AdminModel $adminModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
    }
}
