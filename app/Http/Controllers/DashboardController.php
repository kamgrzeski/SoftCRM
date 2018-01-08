<?php

namespace App\Http\Controllers;

use App\Client;
use App\Invoices;
use App\Products;
use App\Tasks;
use Carbon\Carbon;
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
        $tasks = Tasks::all()->sortBy('created_at', 0, true)->slice(0, 5);
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
        $products = Products::all();
        $productSum = 0;


        foreach($products as $product) {
            $productSum += $product->price * $product->count;
        }

        $oficialSum = $productSum;

        return \ClickNow\Money\Money::{config('crm_settings.currency')}($oficialSum);
    }

    /**
     * @return mixed
     */
    public static function countTodayIncome()
    {
        $yesterdayAmount = self::countYesterdayIncome()->getAmount();

        $products = Products::whereDate('created_at', Carbon::today())->get();
        $productSum = 0;

        foreach($products as $product) {
            $productSum += $product->price * $product->count;
        }

        $todayIncome = $productSum;

        return \ClickNow\Money\Money::{config('crm_settings.currency')}($todayIncome);
    }

    /**
     * @return mixed
     */
    public static function countYesterdayIncome()
    {
        $products = Products::whereDate('created_at', Carbon::yesterday())->get();
        $productSum = 0;

        foreach($products as $product) {
            $productSum += $product->price * $product->count;
        }

        $yesterdayIncome = $productSum;

        return \ClickNow\Money\Money::{config('crm_settings.currency')}($yesterdayIncome);
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
