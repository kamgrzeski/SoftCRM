<?php

namespace App\Http\Controllers;

use App\Services\GraphDataService;
use App\Traits\Language;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, Language;

    public function taskGraphData()
    {
        $graph = new GraphDataService();

        return $graph->taskGraphData();
    }

    public function itemsCountGraphData()
    {
        $graph = new GraphDataService();

        return $graph->itemsCountGraphData();
    }

    public function getAdminRoleType()
    {
        return Auth::user()->role_type;
    }

    public function getAdminId()
    {
        return Auth::id();
    }
}
