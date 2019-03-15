<?php

namespace App\Http\Controllers;

use App\Services\CalculateCashService;
use App\Services\CompaniesService;
use App\Services\GraphDataService;
use App\Services\HelpersFncService;
use App\Services\ProductsService;

class DashboardController extends Controller
{
    private $companieService;
    private $productsService;
    private $helpersFncService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->companieService = new CompaniesService();
        $this->productsService = new ProductsService();
        $this->helpersFncService = new HelpersFncService();

        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index')->with([
            'dataWithAllTasks' => $this->helpersFncService->formatTasks(),
            'dataWithAllCompanies' => $this->companieService->loadCompaniesByCreatedAt(),
            'dataWithAllProducts' => $this->productsService->loadProductsByCreatedAt(),
            'tasksGraphData' => $this->taskGraphData(),
            'itemsCountGraphData' => $this->itemsCountGraphData()
        ]);
    }

    /**
     * @return mixed
     */
    public static function countCashTurnover()
    {
        $cash = new CalculateCashService();

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
        $cash = new CalculateCashService();

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
        $cash = new CalculateCashService();

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
        $cash = new CalculateCashService();

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

        $cash = new CalculateCashService();

        if($cash) {
            return $cash->calculateTaskEveryMonth($isCompleted);
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function taskGraphData() {

        $graph = new GraphDataService();

        if($graph) {
            return $graph->taskGraphData();
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function itemsCountGraphData() {
        $graph = new GraphDataService();

        if($graph) {
            return $graph->itemsCountGraphData();
        }

        return false;
    }

}
