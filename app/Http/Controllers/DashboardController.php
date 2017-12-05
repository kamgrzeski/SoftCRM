<?php

namespace App\Http\Controllers;

use App\Client;
use App\Invoices;
use App\Products;
use App\Tasks;
use Illuminate\Support\Facades\DB;

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

    /**
     * @return mixed
     */
    public static function countCashTurnover()
    {
//        $sales = Sales::all();
//        $salesSum = 0;
//        $finances = Finances::all();
//        $financesSum = 0;
        $clients = Client::all();
        $clientSum = 0;
        $products = Products::all();
        $productSum = 0;

        foreach($clients as $client) {
            $clientSum += $client->budget;
        }
        foreach($products as $product) {
            $productSum += $product->price * $product->count;
        }

        $oficialSum = $clientSum + $productSum;

        return \ClickNow\Money\Money::{config('crm_settings.currency')}($oficialSum);
    }

    /**
     * @return int
     */
    public static function countAllRowsInDb()
    {
        $counter = 0;
        $tables = array_map('reset', \DB::select('SHOW TABLES'));

        foreach ($tables as $table) {
            $counter += DB::table($table)->count();
        }

        return $counter;
    }
}
