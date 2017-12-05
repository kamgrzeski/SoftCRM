<?php

namespace App\Http\Controllers;

use App\Invoices;
use App\Products;
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
        $dataWithAllInvoices = Invoices::all()->sortBy('created_at', 0, true)->slice(0, 5);
        $dataWithAllProducts = Products::all()->sortBy('created_at', 0, true)->slice(0, 5);

        return view('index')->with([
            'dataWithAllTasks' => $this->formatTasks(),
            'dataWithAllInvoices' => $dataWithAllInvoices,
            'dataWithAllProducts' => $dataWithAllProducts
        ]);
    }

    /**
     * @return array
     */
    public function formatTasks()
    {
        $tasks = Tasks::all();
        $arrayWithFormattedTasks = [];

        foreach ($tasks as $key => $task) {
            $nameTask = substr($task->name, 0, 80);
            $nameTask .= '[..]';

            $arrayWithFormattedTasks[$key] = [
                'id' => $task->id,
                'name' => $nameTask,
                'created_at' => $task->created_at
            ];
        }

        return $arrayWithFormattedTasks;

    }
}
