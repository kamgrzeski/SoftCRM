<?php

namespace App\Http\Controllers;

use App\Deals;
use App\Finances;
use App\Invoices;
use App\Products;
use App\Projects;
use App\Sales;
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
            'dataWithAllProducts' => $dataWithAllProducts,
            'tasksGraphData' => $this->taskGraphData(),
            'itemsCountGraphData' => $this->itemsCountGraphData()
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
            $nameTask = substr($task->name, 0, 70);
            $nameTask .= '[..]';

            $arrayWithFormattedTasks[$key] = [
                'id' => $task->id,
                'name' => $nameTask,
                'duration' => $task->duration,
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

    /**
     * @param $isCompleted
     * @return array
     */
    public function calculateTaskEveryMonth($isCompleted) {

        $dates = collect();
        foreach( range( -6, 0 ) AS $i ) {
            $date = Carbon::now()->addDays( $i )->format( 'Y-m-d' );
            $dates->put( $date, 0);
        }

        if($isCompleted) {
            $posts = Tasks::where( 'created_at', '>=', $dates->keys()->first() )->where('completed', '=', 1)
                ->groupBy( 'date' )
                ->orderBy( 'date' )
                ->get( [
                    DB::raw( 'DATE( created_at ) as date' ),
                    DB::raw( 'COUNT( * ) as "count"' )
                ] )
                ->pluck( 'count', 'date' );
        } else {
            $posts = Tasks::where( 'created_at', '>=', $dates->keys()->first() )
                ->groupBy( 'date' )
                ->orderBy( 'date' )
                ->get( [
                    DB::raw( 'DATE( created_at ) as date' ),
                    DB::raw( 'COUNT( * ) as "count"' )
                ] )
                ->pluck( 'count', 'date' );
        }

        $dates = $dates->merge( $posts )->toArray();

        return array_values($dates);
    }

    /**
     * @return mixed
     */
    public function taskGraphData() {
         $taskGraphData = app()->chartjs
            ->name('taskGraphData')
            ->type('line')
            ->size(['width' => 400, 'height' => 200])
            ->labels(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'])
            ->datasets([
                [
                    "label" => "Added tasks",
                    'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                    'borderColor' => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => $this->calculateTaskEveryMonth($isCompleted = false)
                ],
                [
                    "label" => "Completed tasks",
                    'backgroundColor' => "rgba(38, 80, 186, 0.55)",
                    'borderColor' => "rgba(38, 80, 186, 1)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => $this->calculateTaskEveryMonth($isCompleted = true)
                ]
            ])
            ->options([]);

        return $taskGraphData;
    }

    /**
     * @return mixed
     */
    public function itemsCountGraphData() {
        $itemsCountGraphData = app()->chartjs
            ->name('cashTurnoverGraphData')
            ->type('bar')
            ->size(['width' => 400, 'height' => 200])
            ->datasets([
                [
                    "label" => "Products",
                    'backgroundColor' => ['rgba(227, 67, 51, 1)', 'rgba(54, 162, 235, 0.2)'],
                    'data' => [Products::countProducts()]
                ],
                [
                    "label" => "Sales",
                    'backgroundColor' => ['rgba(228, 115, 45, 1)', 'rgba(54, 162, 235, 0.3)'],
                    'data' => [Sales::countSales()]
                ],
                [
                    "label" => "Finances",
                    'backgroundColor' => ['rgba(249, 195, 100, 1)', 'rgba(54, 162, 235, 0.3)'],
                    'data' => [Finances::countFinances()]
                ],
                [
                    "label" => "Projects",
                    'backgroundColor' => ['rgba(151, 186, 241, 1)', 'rgba(54, 162, 235, 0.3)'],
                    'data' => [Projects::countProjects()]
                ],
                [
                    "label" => "Deals",
                    'backgroundColor' => ['rgba(92, 141, 93, 1)', 'rgba(54, 162, 235, 0.3)'],
                    'data' => [Deals::countDeals()]
                ]
            ])
            ->options([]);

        return $itemsCountGraphData;

    }

}
