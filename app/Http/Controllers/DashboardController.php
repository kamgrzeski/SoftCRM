<?php

namespace App\Http\Controllers;

use App\Services\CalculateCashService;
use App\Services\CompaniesService;
use App\Services\GraphDataService;
use App\Services\HelpersFncService;
use App\Services\ProductsService;
use View;

class DashboardController extends Controller
{
    private $companieService;
    private $productsService;
    private $helpersFncService;

    public function __construct()
    {
        $this->companieService = new CompaniesService();
        $this->productsService = new ProductsService();
        $this->helpersFncService = new HelpersFncService();

        $this->middleware('auth');
    }

    public function index()
    {
        return View::make('index')->with([
            'dataWithAllTasks' => $this->helpersFncService->formatTasks(),
            'dataWithAllCompanies' => $this->companieService->loadCompaniesByCreatedAt(),
            'dataWithAllProducts' => $this->productsService->loadProductsByCreatedAt(),
            'tasksGraphData' => $this->taskGraphData(),
            'itemsCountGraphData' => $this->itemsCountGraphData()
        ]);
    }

    public static function countCashTurnover()
    {
        $cash = new CalculateCashService();

        if ($cash) {
            return $cash->countCashTurnover();
        }

        return false;
    }

    public static function countTodayIncome()
    {
        $cash = new CalculateCashService();

        if ($cash) {
            return $cash->countTodayIncome();
        }

        return false;
    }

    public static function countYesterdayIncome()
    {
        $cash = new CalculateCashService();

        if ($cash) {
            return $cash->countYesterdayIncome();
        }

        return false;
    }

    public static function countAllRowsInDb()
    {
        $cash = new CalculateCashService();

        if ($cash) {
            return $cash->countAllRowsInDb();
        }

        return false;
    }

    public function calculateTaskEveryMonth($isCompleted)
    {

        $cash = new CalculateCashService();

        if ($cash) {
            return $cash->calculateTaskEveryMonth($isCompleted);
        }

        return false;
    }

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
