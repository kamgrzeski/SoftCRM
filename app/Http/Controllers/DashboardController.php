<?php

namespace App\Http\Controllers;

use App\Services\CalculateCashService;
use App\Services\ClientService;
use App\Services\CompaniesService;
use App\Services\DealsService;
use App\Services\EmployeesService;
use App\Services\FinancesService;
use App\Services\GraphDataService;
use App\Services\HelpersFncService;
use App\Services\ProductsService;
use App\Services\SalesService;
use App\Services\SettingsService;
use App\Services\SystemLogService;
use App\Services\TasksService;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    private ClientService $clientService;
    private HelpersFncService $helpersFncService;
    private CompaniesService $companiesService;
    private ProductsService $productsService;
    private CalculateCashService $calculateCashService;
    private EmployeesService $employeesService;
    private DealsService $dealsService;
    private FinancesService $financesService;
    private TasksService $tasksService;
    private SalesService $salesService;
    private SystemLogService $systemLogService;
    private SettingsService $settingsService;

    private int $cacheTime = 5940000; //cache set for 99 minutes

    public function __construct()
    {
        $this->middleware(self::MIDDLEWARE_AUTH);

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

        $graph = new GraphDataService();

        return view('index')->with(
            [
                'tasksGraphData' => $graph->taskGraphData(),
                'itemsCountGraphData' => $graph->itemsCountGraphData(),
                'dataWithAllTasks' => $this->helpersFncService->formatTasks(),
                'dataWithAllCompanies' => $this->companiesService->loadCompaniesByCreatedAt(),
                'dataWithAllProducts' => $this->productsService->loadProductsByCreatedAt(),
                'currency' => $this->settingsService->loadSettingValue(self::CURRENCY)
            ]
        );
    }

    private function storeInCacheUsableVariables()
    {
        Cache::put('countClients', $this->clientService->loadCountClients(), $this->cacheTime);
        Cache::put('deactivatedClients', $this->clientService->loadDeactivatedClients(), $this->cacheTime);
        Cache::put('clientsInLatestMonth', $this->clientService->loadClientsInLatestMonth(), $this->cacheTime);
        Cache::put('countCompanies', $this->companiesService->loadCountCompanies(), $this->cacheTime);
        Cache::put('countEmployees', $this->employeesService->loadCountEmployees(), $this->cacheTime);
        Cache::put('countDeals', $this->dealsService->loadCountDeals(), $this->cacheTime);
        Cache::put('countFinances', $this->financesService->loadCountFinances(), $this->cacheTime);
        Cache::put('countProducts', $this->productsService->loadCountProducts(), $this->cacheTime);
        Cache::put('countTasks', $this->tasksService->loadCountTasks(), $this->cacheTime);
        Cache::put('countSales', $this->salesService->loadCountSales(), $this->cacheTime);
        Cache::put('deactivatedCompanies', $this->companiesService->loadDeactivatedCompanies(), $this->cacheTime);
        Cache::put('todayIncome', $this->calculateCashService->loadCountTodayIncome(), $this->cacheTime);
        Cache::put('yesterdayIncome', $this->calculateCashService->loadCountYesterdayIncome(), $this->cacheTime);
        Cache::put('cashTurnover', $this->calculateCashService->loadCountCashTurnover(), $this->cacheTime);
        Cache::put('countAllRowsInDb', $this->calculateCashService->loadCountAllRowsInDb(), $this->cacheTime);
        Cache::put('countSystemLogs', $this->systemLogService->loadCountLogs(), $this->cacheTime);
        Cache::put('companiesInLatestMonth', $this->companiesService->loadCompaniesInLatestMonth(), $this->cacheTime);
        Cache::put('employeesInLatestMonth', $this->employeesService->loadEmployeesInLatestMonth(), $this->cacheTime);
        Cache::put('deactivatedEmployees', $this->employeesService->loadDeactivatedEmployees(), $this->cacheTime);
        Cache::put('deactivatedDeals', $this->dealsService->loadDeactivatedDeals(), $this->cacheTime);
        Cache::put('dealsInLatestMonth', $this->dealsService->loadDealsInLatestMonth(), $this->cacheTime);
        Cache::put('completedTasks', $this->tasksService->loadCompletedTasks(), $this->cacheTime);
        Cache::put('uncompletedTasks', $this->tasksService->loadUncompletedTasks(), $this->cacheTime);
    }

    public function processReloadInformation()
    {
        $this->storeInCacheUsableVariables();

        return redirect()->back()->with('message_success', $this->getMessage('messages.cache_reload'));
    }
}
