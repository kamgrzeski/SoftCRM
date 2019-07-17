<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginAdminRequest;
use App\Services\AdministratorService;
use Auth;
use Illuminate\Http\{JsonResponse};

class AdminController extends Controller
{
    protected $startTime;
    private $administratorService;

    public function __construct()
    {
        parent::__construct();

        $this->startTime = microtime(true);
        $this->administratorService = new AdministratorService();
    }

    public function loginAdmin(LoginAdminRequest $request): JsonResponse
    {
        $validated = $this->convertToObject($request->validated());

        if ($adminDetails = $this->administratorService->processLoginAdmin($validated)) {
            return $this->jsonResponse('You have successfully logged in to SoftCRM!', $adminDetails, $this->acceptedCode, $this->startTime);
        } else {
            return $this->jsonResponse('This admin account doesn\'t exist or you pass invalid credentials.', [], $this->unauthorized, $this->startTime);
        }
    }

    public function checkLoginAdmin(): JsonResponse
    {
        if ($adminId = $this->administratorService->processCheckLoginAdmin()) {
            return $this->jsonResponse('You are already logged in !', ['adminId' => $adminId], $this->acceptedCode, $this->startTime);
        } else {
            return $this->jsonResponse('You are not logged in.', [], $this->acceptedCode, $this->startTime);
        }
    }

    public function logoutAdmin(): JsonResponse
    {
        $this->administratorService->processLogoutAdmin();

        return $this->jsonResponse('You have successfully logged out!', [], $this->successCode, $this->startTime);
    }
    
    public function getAdminDetails() : JsonResponse
    {
        $adminId = $this->getAdminId();

        if($adminDetails = $this->administratorService->loadAdminDetails($adminId)) {
            return $this->jsonResponse('Admin details.', $adminDetails, $this->successCode, $this->startTime);
        } else {
            return $this->jsonResponse('Admin account doesn\'t exists.', [], $this->unauthorized, $this->startTime);
        }
    }
}
