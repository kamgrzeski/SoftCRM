<?php

namespace App\Services;

use App\Models\AdminModel;

/**
 * Class AdminService
 *
 * Service class for handling operations related to the AdminModel.
 */
class AdminService
{
    private AdminModel $adminModel;

    /**
     * AdminService constructor.
     *
     * Initializes a new instance of the AdminModel.
     */
    public function __construct()
    {
        $this->adminModel = new AdminModel();
    }
}
