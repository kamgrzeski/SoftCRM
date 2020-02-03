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
use App\Services\SettingsService;
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
    private $settingsService;

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
        $this->settingsService = new SettingsService();
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
                'currency' => $this->settingsService->loadSettingValue('currency')
            ]
        );
    }

    public function calculateTaskEveryMonth($isCompleted)
    {
        return $this->calculateCashService->loadTaskEveryMonth($isCompleted);
    }

    //cache set for 99 minutes
    private function storeInCacheUsableVariables()
    {
        Cache::put('countClients', $this->clientService->loadCountClients(), 99);
        Cache::put('deactivatedClients', $this->clientService->loadDeactivatedClients(), 99);
        Cache::put('clientsInLatestMonth', $this->clientService->loadClientsInLatestMonth(), 99);
        Cache::put('countCompanies', $this->companiesService->loadCountCompanies(), 99);
        Cache::put('countEmployees', $this->employeesService->loadCountEmployees(), 99);
        Cache::put('countDeals', $this->dealsService->loadCountDeals(), 99);
        Cache::put('countFinances', $this->financesService->loadCountFinances(), 99);
        Cache::put('countProducts', $this->productsService->loadCountProducts(), 99);
        Cache::put('countTasks', $this->tasksService->loadCountTasks(), 99);
        Cache::put('countSales', $this->salesService->loadCountSales(), 99);
        Cache::put('deactivatedCompanies', $this->companiesService->loadDeactivatedCompanies(), 99);
        Cache::put('todayIncome', $this->calculateCashService->loadCountTodayIncome(), 99);
        Cache::put('yesterdayIncome', $this->calculateCashService->loadCountYesterdayIncome(), 99);
        Cache::put('cashTurnover', $this->calculateCashService->loadCountCashTurnover(), 99);
        Cache::put('countAllRowsInDb', $this->calculateCashService->loadCountAllRowsInDb(), 99);
        Cache::put('countSystemLogs', $this->systemLogService->loadCountLogs(), 99);
        Cache::put('companiesInLatestMonth', $this->companiesService->loadCompaniesInLatestMonth(), 99);
        Cache::put('employeesInLatestMonth', $this->employeesService->loadEmployeesInLatestMonth(), 99);
        Cache::put('deactivatedEmployees', $this->employeesService->loadDeactivatedEmployees(), 99);
        Cache::put('deactivatedDeals', $this->dealsService->loadDeactivatedDeals(), 99);
        Cache::put('dealsInLatestMonth', $this->dealsService->loadDealsInLatestMonth(), 99);
        Cache::put('completedTasks', $this->tasksService->loadCompletedTasks(), 99);
        Cache::put('uncompletedTasks', $this->tasksService->loadUncompletedTasks(), 99);
    }
}
