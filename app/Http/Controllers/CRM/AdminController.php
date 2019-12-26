<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use View;
use Auth;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return View::make('admin.login');
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
}
