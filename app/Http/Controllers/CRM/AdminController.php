<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\LoginAdminRequest;
use App\Jobs\ChangePasswordJob;

/**
 * Class AdminController
 *
 * Controller for handling admin-related operations in the CRM.
 */
class AdminController extends Controller
{
    /**
     * Show the login form for admin.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm(): \Illuminate\View\View
    {
        // Render the login form.
        return view('admin.login');
    }

    /**
     * Process the admin login.
     *
     * @param LoginAdminRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processLoginAdmin(LoginAdminRequest $request)
    {
        // Validate the request.
        if (auth()->attempt($request->validated())) {
            return redirect()->to('/');
        } else {
            return redirect()->back()->with('message-error', 'Wrong email or password!');
        }
    }

    /**
     * Logout the admin from the system.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(): \Illuminate\Http\RedirectResponse
    {
        // Logout from system
        auth()->logout();

        // Redirect to login page
        return redirect()->to('login')->with('message_success', 'You have been logged out from system.');
    }

    /**
     * Render the view for changing the password.
     *
     * @return \Illuminate\View\View
     */
    public function renderChangePasswordView(): \Illuminate\View\View
    {
        // Render the change password view.
        return view('admin.passwords.reset');
    }

    /**
     * Process the password change request.
     *
     * @param ChangePasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processChangePassword(ChangePasswordRequest $request): \Illuminate\Http\RedirectResponse
    {
        // Get validated data.
        $validatedData = $request->validated();

        // Dispatch job to change password.
        $this->dispatchSync(new ChangePasswordJob($validatedData['old_password'], $validatedData['new_password'], $validatedData['confirm_password'], auth()->user()));

        // Redirect to change password page.
        return redirect()->to('password/reset')->with('message_success', 'Your password has been changed.');
    }
}
