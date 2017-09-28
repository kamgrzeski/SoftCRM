<?php

namespace App\Http\Controllers;

use App\Invoices;
use App\Tasks;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataWithAllTasks = Tasks::all()->sortBy('created_at' , 0, true)->slice(0, 5);
        $dataWithAllInvoices = Invoices::all()->sortBy('created_at', 0, true)->slice(0, 5);

        return view('index')->with([
            'dataWithAllTasks' => $dataWithAllTasks,
            'dataWithAllInvoices' => $dataWithAllInvoices
        ]);
    }
}
