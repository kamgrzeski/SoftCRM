<?php

namespace App\Services;

use App\Models\AdminModel;
use Illuminate\Support\Facades\Hash;

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

        $adminDetails = $this->adminModel->changeAdminPassword($adminId);

        if(Hash::check($oldPassword, $adminDetails->password)) {
            return $this->adminModel->updateAdminPassword($newPassword, $adminId);
        } else {
            return false;
        }
    }
}
