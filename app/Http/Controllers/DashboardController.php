<?php

namespace App\Http\Controllers;

use App\Services\CalculateCashService;
use App\Services\ClientService;
use App\Services\CompaniesService;
use App\Services\DealsService;
use App\Services\EmployeesService;
use App\Services\FinancesService;
use App\Services\HelpersFncService;
use App\Services\ProductsService;
use App\Services\SalesService;
use App\Services\SystemLogService;
use App\Services\TasksService;
use Illuminate\Support\Facades\Cache;
use View;

class DashboardController extends Controller
{
    private $clientService;
    private $helpersFncService;
    private $companiesService;
    private $productsService;
    private $calculateCashService;
    private $employeesService;
    private $dealsService;
    private $financesService;
    private $tasksService;
    private $salesService;
    private $systemLogService;

    public function __construct()
    {
        $this->middleware('auth');

        $this->clientService = new ClientService();
        $this->helpersFncService = new helpersFncService();
        $this->companiesService = new CompaniesService();
        $this->productsService = new ProductsService();
        $this->calculateCashService = new CalculateCashService();
        $this->employeesService = new EmployeesService();
        $this->dealsService = new DealsService();
        $this->financesService = new FinancesService();
        $this->tasksService = new TasksService();
        $this->salesService = new SalesService();
        $this->systemLogService = new SystemLogService();
    }

    public function index()
    {
        $this->storeInCacheUsableVariables();

        return View::make('index')->with(
            [
                'tasksGraphData' => $this->taskGraphData(),
                'itemsCountGraphData' => $this->itemsCountGraphData(),
                'dataWithAllTasks' => $this->helpersFncService->formatTasks(),
                'dataWithAllCompanies' => $this->companiesService->loadCompaniesByCreatedAt(),
                'dataWithAllProducts' => $this->productsService->loadProductsByCreatedAt(),
            ]
        );
    }

    public function calculateTaskEveryMonth($isCompleted)
    {
        return $this->calculateCashService->calculateTaskEveryMonth($isCompleted);
    }

    private function storeInCacheUsableVariables()
    {
        Cache::put('countClients', $this->clientService->countClients(), null);
        Cache::put('deactivatedClients', $this->clientService->loadDeactivatedClients(), null);
        Cache::put('clientsInLatestMonth', $this->clientService->loadClientsInLatestMonth(), null);
        Cache::put('countCompanies', $this->companiesService->loadCountCompanies(), null);
        Cache::put('countEmployees', $this->employeesService->loadCountEmployees(), null);
        Cache::put('countDeals', $this->dealsService->loadCountDeals(), null);
        Cache::put('countFinances', $this->financesService->loadCountFinances(), null);
        Cache::put('countProducts', $this->productsService->loadCountProducts(), null);
        Cache::put('countTasks', $this->tasksService->loadCountTasks(), null);
        Cache::put('countSales', $this->salesService->loadCountSales(), null);
        Cache::put('deactivatedCompanies', $this->companiesService->loadDeactivatedCompanies(), null);
        Cache::put('todayIncome', $this->calculateCashService->countTodayIncome(), null);
        Cache::put('yesterdayIncome', $this->calculateCashService->countYesterdayIncome(), null);
        Cache::put('cashTurnover', $this->calculateCashService->countCashTurnover(), null);
        Cache::put('countAllRowsInDb', $this->calculateCashService->countAllRowsInDb(), null);
        Cache::put('countSystemLogs', $this->systemLogService->loadCountLogs(), null);
        Cache::put('companiesInLatestMonth', $this->companiesService->loadCompaniesInLatestMonth(), null);
        Cache::put('employeesInLatestMonth', $this->employeesService->loadEmployeesInLatestMonth(), null);
        Cache::put('deactivatedEmployees', $this->employeesService->loadDeactivatedEmployees(), null);
        Cache::put('deactivatedDeals', $this->dealsService->loadDeactivatedDeals(), null);
        Cache::put('dealsInLatestMonth', $this->dealsService->loadDealsInLatestMonth(), null);
        Cache::put('completedTasks', $this->tasksService->loadCompletedTasks(), null);
        Cache::put('uncompletedTasks', $this->tasksService->loadUncompletedTasks(), null);
    }
}
