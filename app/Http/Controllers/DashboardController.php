<?php

namespace App\Http\Controllers;

use App\Queries\ClientsQueries;
use App\Queries\CompaniesQueries;
use App\Queries\DealsQueries;
use App\Queries\EmployeesQueries;
use App\Queries\FinancesQueries;
use App\Queries\ProductsQueries;
use App\Queries\SalesQueries;
use App\Queries\SystemLogsQueries;
use App\Queries\TasksQueries;
use App\Services\CalculateCashService;
use App\Services\ClientService;
use App\Services\CompaniesService;
use App\Services\DealsService;
use App\Services\EmployeesService;
use App\Services\GraphDataService;
use App\Services\SettingsService;
use App\Services\TasksService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class DashboardController extends Controller
{
    private ClientService $clientService;
    private CompaniesService $companiesService;
    private CalculateCashService $calculateCashService;
    private EmployeesService $employeesService;
    private DealsService $dealsService;
    private TasksService $tasksService;
    private SettingsService $settingsService;

    public function __construct()
    {
        $this->middleware(self::MIDDLEWARE_AUTH);

        $this->clientService = new ClientService();
        $this->companiesService = new CompaniesService();
        $this->calculateCashService = new CalculateCashService();
        $this->employeesService = new EmployeesService();
        $this->dealsService = new DealsService();
        $this->tasksService = new TasksService();
        $this->settingsService = new SettingsService();
    }

    /**
     * Index page.
     *
     * @return View
     */
    public function index(): \Illuminate\View\View
    {
        $this->storeInCacheUsableVariables();

        $graph = new GraphDataService();

        return view('crm.dashboard.index')->with(
            [
                'tasksGraphData' => $graph->taskGraphData(),
                'itemsCountGraphData' => $graph->itemsCountGraphData(),
                'dataWithAllTasks' => $this->tasksService->formatTasks(),
                'dataWithAllCompanies' => $this->companiesService->loadCompaniesByCreatedAt(),
                'dataWithAllProducts' => ProductsQueries::getProductsByCreatedAt(),
                'currency' => $this->settingsService->loadSettingValue(self::CURRENCY)
            ]
        );
    }

    /**
     *  Store in cache usable variables.
     *
     * @return void
     */
    private function storeInCacheUsableVariables(): void
    {
        Cache::put('countClients', ClientsQueries::getCountAll(), env('CACHE_TIME'));
        Cache::put('deactivatedClients', ClientsQueries::getDeactivated(), env('CACHE_TIME'));
        Cache::put('clientsInLatestMonth', $this->clientService->loadClientsInLatestMonth(), env('CACHE_TIME'));
        Cache::put('countCompanies', CompaniesQueries::countAll(), env('CACHE_TIME'));
        Cache::put('countEmployees', EmployeesQueries::countAll(), env('CACHE_TIME'));
        Cache::put('countDeals', DealsQueries::countAll(), env('CACHE_TIME'));
        Cache::put('countFinances', FinancesQueries::countAll(), env('CACHE_TIME'));
        Cache::put('countProducts', ProductsQueries::countAll(), env('CACHE_TIME'));
        Cache::put('countTasks', TasksQueries::countAll(), env('CACHE_TIME'));
        Cache::put('countSales', SalesQueries::countAll(), env('CACHE_TIME'));
        Cache::put('deactivatedCompanies', CompaniesQueries::getDeactivated(), env('CACHE_TIME'));
        Cache::put('todayIncome', $this->calculateCashService->loadCountTodayIncome(), env('CACHE_TIME'));
        Cache::put('yesterdayIncome', $this->calculateCashService->loadCountYesterdayIncome(), env('CACHE_TIME'));
        Cache::put('cashTurnover', $this->calculateCashService->loadCountCashTurnover(), env('CACHE_TIME'));
        Cache::put('countAllRowsInDb', $this->calculateCashService->loadCountAllRowsInDb(), env('CACHE_TIME'));
        Cache::put('countSystemLogs', SystemLogsQueries::countAll(), env('CACHE_TIME'));
        Cache::put('companiesInLatestMonth', $this->companiesService->loadCompaniesInLatestMonth(), env('CACHE_TIME'));
        Cache::put('employeesInLatestMonth', $this->employeesService->loadEmployeesInLatestMonth(), env('CACHE_TIME'));
        Cache::put('deactivatedEmployees', EmployeesQueries::getDeactivated(), env('CACHE_TIME'));
        Cache::put('deactivatedDeals', DealsQueries::getDeactivated(), env('CACHE_TIME'));
        Cache::put('dealsInLatestMonth', $this->dealsService->loadDealsInLatestMonth(), env('CACHE_TIME'));
        Cache::put('completedTasks', $this->tasksService->loadCompletedTasks(), env('CACHE_TIME'));
        Cache::put('uncompletedTasks', $this->tasksService->loadUncompletedTasks(), env('CACHE_TIME'));
    }

    /**
     *  Reload information in cache.
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function processReloadInformation(): \Illuminate\Http\RedirectResponse
    {
        // Clear cache.
        $this->storeInCacheUsableVariables();

        // Redirect back with success message.
        return redirect()->back()->with('message_success', $this->getMessage('messages.cache_reload'));
    }
}
