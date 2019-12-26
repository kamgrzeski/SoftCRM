<?php

namespace App\Http\Controllers;

use View;

class DashboardController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function index()
    {
        return View::make('index')->with($this->collectedData(TRUE));
    }

    public function calculateTaskEveryMonth($isCompleted)
    {
        return $this->calculateCashService->calculateTaskEveryMonth($isCompleted);
    }
}
