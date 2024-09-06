<?php

namespace App\Http\Controllers;

use App\Traits\Language;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, Language;

    const CURRENCY = 'currency';
    const MIDDLEWARE_AUTH = 'auth';
}
