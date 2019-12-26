<?php

namespace App\Http\Controllers;

use App\Services\GraphDataService;
use App\Traits\Language;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, Language;

    public function taskGraphData()
    {
        $graph = new GraphDataService();

        if ($graph) {
            return $graph->taskGraphData();
        }

        return false;
    }

    public function itemsCountGraphData()
    {
        $graph = new GraphDataService();

        if ($graph) {
            return $graph->itemsCountGraphData();
        }

        return false;
    }
}
