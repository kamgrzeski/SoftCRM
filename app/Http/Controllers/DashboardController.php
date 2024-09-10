<?php

namespace App\Http\Controllers;

use App\Queries\SystemLogsQueries;
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
use Illuminate\Http\RedirectResponse;
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

    private function storeInCacheUsableVariables(): void
    {
        Cache::put('countClients', $this->clientService->loadCountClients(), env('CACHE_TIME'));
        Cache::put('deactivatedClients', $this->clientService->loadDeactivatedClients(), env('CACHE_TIME'));
        Cache::put('clientsInLatestMonth', $this->clientService->loadClientsInLatestMonth(), env('CACHE_TIME'));
        Cache::put('countCompanies', $this->companiesService->loadCountCompanies(), env('CACHE_TIME'));
        Cache::put('countEmployees', $this->employeesService->loadCountEmployees(), env('CACHE_TIME'));
        Cache::put('countDeals', $this->dealsService->loadCountDeals(), env('CACHE_TIME'));
        Cache::put('countFinances', $this->financesService->loadCountFinances(), env('CACHE_TIME'));
        Cache::put('countProducts', $this->productsService->loadCountProducts(), env('CACHE_TIME'));
        Cache::put('countTasks', $this->tasksService->loadCountTasks(), env('CACHE_TIME'));
        Cache::put('countSales', $this->salesService->loadCountSales(), env('CACHE_TIME'));
        Cache::put('deactivatedCompanies', $this->companiesService->loadDeactivatedCompanies(), env('CACHE_TIME'));
        Cache::put('todayIncome', $this->calculateCashService->loadCountTodayIncome(), env('CACHE_TIME'));
        Cache::put('yesterdayIncome', $this->calculateCashService->loadCountYesterdayIncome(), env('CACHE_TIME'));
        Cache::put('cashTurnover', $this->calculateCashService->loadCountCashTurnover(), env('CACHE_TIME'));
        Cache::put('countAllRowsInDb', $this->calculateCashService->loadCountAllRowsInDb(), env('CACHE_TIME'));
        Cache::put('countSystemLogs', SystemLogsQueries::countAll(), env('CACHE_TIME'));
        Cache::put('companiesInLatestMonth', $this->companiesService->loadCompaniesInLatestMonth(), env('CACHE_TIME'));
        Cache::put('employeesInLatestMonth', $this->employeesService->loadEmployeesInLatestMonth(), env('CACHE_TIME'));
        Cache::put('deactivatedEmployees', $this->employeesService->loadDeactivatedEmployees(), env('CACHE_TIME'));
        Cache::put('deactivatedDeals', $this->dealsService->loadDeactivatedDeals(), env('CACHE_TIME'));
        Cache::put('dealsInLatestMonth', $this->dealsService->loadDealsInLatestMonth(), env('CACHE_TIME'));
        Cache::put('completedTasks', $this->tasksService->loadCompletedTasks(), env('CACHE_TIME'));
        Cache::put('uncompletedTasks', $this->tasksService->loadUncompletedTasks(), env('CACHE_TIME'));
    }

    /**
     * @return RedirectResponse
     */
    public function processReloadInformation(): \Illuminate\Http\RedirectResponse
    {
        // Clear cache.
        $this->storeInCacheUsableVariables();

        // Redirect back with success message.
        return redirect()->back()->with('message_success', $this->getMessage('messages.cache_reload'));
    }
}
