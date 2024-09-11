<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\LoginAdminRequest;
use App\Jobs\ChangePasswordJob;
use Illuminate\Support\Facades\Hash;

/**
 * Class AdminController
 *
 * Controller for handling admin-related operations in the CRM.
 */
class AuthController extends Controller
{
    /**
     * Show the login form for admin.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm(): \Illuminate\View\View
    {
        // Render the login form.
        return view('crm.auth.login');
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
            return redirect()->back()->with('message_error', 'Wrong email or password!');
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
        return view('crm.auth.passwords.reset');
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

        // Check if old password is correct.
        if (!Hash::check($validatedData['old_password'], auth()->user()->password)) {
            return redirect()->to('password/reset')->with('message_danger', 'Old password is incorrect.');
        }

        // Check if new password and confirm password match.
        if ($validatedData['new_password'] !== $validatedData['confirm_password']) {
            return redirect()->to('password/reset')->with('message_danger', 'New password and confirm password do not match.');
        }

        // Dispatch job to change password.
        $this->dispatchSync(new ChangePasswordJob($validatedData, auth()->user()));

        // Redirect to change password page.
        return redirect()->to('password/reset')->with('message_success', 'Your password has been changed.');
    }
}
