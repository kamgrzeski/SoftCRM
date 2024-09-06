<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Auth;

class AdminController extends Controller
{
    private AdminService $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function processLoginAdmin(Request $request)
    {
        //TODO validation request
        if (Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')])) {
            return Redirect::to('/');
        } else {
            Session::flash('message-error', 'Wrong email or password!');
            return Redirect::to('login');
        }
    }

    public function logout()
    {
        Session::flash('message-success', 'You have been logged out form system.');
        Auth::logout();
        return Redirect::to('login');
    }

    public function renderChangePasswordView()
    {
        return view('admin.passwords.reset');
    }

    public function processChangePassword(Request $request)
    {
        if($request->get('old_password') == null || $request->get('new_password') == null || $request->get('confirm_password') == null) {
            Session::flash('message_danger', 'All fields are required.');
            return Redirect::to('password/reset');
        }

        if($this->adminService->loadValidatePassword($request->get('old_password'), $request->get('new_password'), $request->get('confirm_password'), $this->getAdminId())) {
            Session::flash('message_success', 'Your password has been changed.');
            return Redirect::to('password/reset');

        } else {
            Session::flash('message_danger', 'You write wrong password!');
            return Redirect::to('password/reset');
        }
    }
}
