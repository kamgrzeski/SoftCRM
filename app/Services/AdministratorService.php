<?php

namespace App\Services;

use App\Models\AdminModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AdministratorService
{
    const SUCCESS = 'OK';
    const ERROR = 'ERROR';

    private $adminModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
    }

    public function processLoginAdmin($requestedData)
    {
        if (Auth::guard('admin')->attempt(['username' => $requestedData->username, 'password' => $requestedData->password], true)) {
            return Auth::guard('admin')->user();
//            $tokenResult = $user->createToken('Personal Access Token');
//            $token = $tokenResult->token;
//            $token->save();
//            return [
//                'access_token' => $tokenResult->accessToken,
//                'token_type' => 'Bearer',
//                'expires_at' => Carbon::parse(
//                    $tokenResult->token->expires_at
//                )->toDateTimeString()
//            ];
        } else {
            return false;
        }
    }

    public function processLogoutAdmin()
    {
        return Auth::guard('admin')->logout();
    }

    public function processCheckLoginAdmin()
    {
        if (Auth::guard('admin')) {
            return Auth::guard('admin')->id();
        } else {
            return false;
        }
    }

    public function loadAdminDetails(int $adminId)
    {
        return $this->adminModel->getAdminDetails($adminId);
    }
}
