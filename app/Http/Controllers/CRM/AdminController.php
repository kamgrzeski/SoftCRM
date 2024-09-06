<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\LoginAdminRequest;
use App\Jobs\ChangePasswordJob;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function showLoginForm(): \Illuminate\View\View
    {
        return view('admin.login');
    }

    public function processLoginAdmin(LoginAdminRequest $request)
    {
        $validatedData = $request->validated();

        if (auth()->attempt($validatedData)) {
            return Redirect::to('/');
        } else {
            Session::flash('message-error', 'Wrong email or password!');
            return Redirect::to('login');
        }
    }

    public function logout()
    {
        // Logout from system
        auth()->logout();

        // Redirect to login page
        Session::flash('message-success', 'You have been logged out form system.');

        // Redirect to login page
        return Redirect::to('login');
    }

    public function renderChangePasswordView(): \Illuminate\View\View
    {
        return view('admin.passwords.reset');
    }

    public function processChangePassword(ChangePasswordRequest $request)
    {
        // Get validated data.
        $validatedData = $request->validated();

        // Dispatch job to change password.
        $this->dispatchSync(new ChangePasswordJob($validatedData['old_password'], $validatedData['new_password'], $validatedData['confirm_password'], auth()->user()));

        // Redirect to change password page.
        return Redirect::to('password/reset')->with('message_success', 'Your password has been changed.');
    }
}
