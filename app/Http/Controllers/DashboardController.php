<?php

namespace App\Http\Controllers;

use App\Companies;
use App\Deals;
use App\Finances;
use App\Products;
use App\Projects;
use App\Sales;
use App\Services\CalculateCash;
use App\Services\CalculateCashService;
use App\Services\graphDataService;
use App\Services\helpersFncService;
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
        $dataWithAllCompanies = Companies::all()->sortBy('created_at', 0, true)->slice(0, 5);
        $dataWithAllProducts = Products::all()->sortBy('created_at', 0, true)->slice(0, 5);

        return view('index')->with([
            'dataWithAllTasks' => $this->formatTasks(),
            'dataWithAllCompanies' => $dataWithAllCompanies,
            'dataWithAllProducts' => $dataWithAllProducts,
            'tasksGraphData' => $this->taskGraphData(),
            'itemsCountGraphData' => $this->itemsCountGraphData()
        ]);
    }

    public function formatTasks()
    {
        $helpers = new helpersFncService();

        if($helpers) {
            return $helpers->formatTasks();
        }

        return false;
    }

    /**
     * @return mixed
     */
    public static function countCashTurnover()
    {
        $cash = new calculateCashService();

        if($cash) {
            return $cash->countCashTurnover();
        }

       return false;
    }

    /**
     * @return mixed
     */
    public static function countTodayIncome()
    {
        $cash = new calculateCashService();

        if($cash) {
            return $cash->countTodayIncome();
        }

        return false;
    }

    /**
     * @return mixed
     */
    public static function countYesterdayIncome()
    {
        $cash = new calculateCashService();

        if($cash) {
            return $cash->countYesterdayIncome();
        }

        return false;
    }

        /**
     * @return int
     */
    public static function countAllRowsInDb()
    {
        $cash = new calculateCashService();

        if($cash) {
            return $cash->countAllRowsInDb();
        }

        return false;
    }

    /**
     * @param $isCompleted
     * @return array|bool
     */
    public function calculateTaskEveryMonth($isCompleted) {

        $cash = new calculateCashService();

        if($cash) {
            return $cash->calculateTaskEveryMonth($isCompleted);
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function taskGraphData() {

        $graph = new graphDataService();

        if($graph) {
            return $graph->taskGraphData();
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function itemsCountGraphData() {
        $graph = new graphDataService();

        if($graph) {
            return $graph->itemsCountGraphData();
        }

        return false;
    }

}
