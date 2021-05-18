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

    public function loadValidatePassword(string $oldPassword, string $newPassword, string $confirmNewPassword, int $adminId): bool|int
    {
        if($newPassword != $confirmNewPassword) {
            return false;
        }

        return $this->adminModel->changeAdminPassword($oldPassword, $newPassword, $adminId);
    }
}
