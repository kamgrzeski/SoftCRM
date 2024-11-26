<?php

namespace App\Http\Controllers;

use App\Enums\Settings;
use App\Queries\ClientQueries;
use App\Queries\CompanyQueries;
use App\Queries\DealQueries;
use App\Queries\EmployeeQueries;
use App\Queries\FinanceQueries;
use App\Queries\ProductQueries;
use App\Queries\SaleQueries;
use App\Queries\SettingQueries;
use App\Queries\SystemLogQueries;
use App\Queries\TaskQueries;
use App\Services\CalculateCashService;
use App\Services\ClientService;
use App\Services\CompaniesService;
use App\Services\DealsService;
use App\Services\EmployeesService;
use App\Services\GraphDataService;
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

    public function __construct()
    {
        $this->clientService = new ClientService();
        $this->companiesService = new CompaniesService();
        $this->calculateCashService = new CalculateCashService();
        $this->employeesService = new EmployeesService();
        $this->dealsService = new DealsService();
        $this->tasksService = new TasksService();
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
                'tasks' => TaskQueries::formatTasks(),
                'companies' => CompanyQueries::getCompaniesSortedByCreatedAt()->take(10),
                'products' => ProductQueries::getProductsByCreatedAt()->take(10),
                'currency' => SettingQueries::getSettingValue(Settings::CURRENCY->value)
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
        Cache::put('countClients', ClientQueries::getCountAll(), env('CACHE_TIME'));
        Cache::put('deactivatedClients', ClientQueries::getDeactivated(), env('CACHE_TIME'));
        Cache::put('clientsInLatestMonth', $this->clientService->loadClientsInLatestMonth(), env('CACHE_TIME'));
        Cache::put('countCompanies', CompanyQueries::countAll(), env('CACHE_TIME'));
        Cache::put('countEmployees', EmployeeQueries::countAll(), env('CACHE_TIME'));
        Cache::put('countDeals', DealQueries::countAll(), env('CACHE_TIME'));
        Cache::put('countFinances', FinanceQueries::countAll(), env('CACHE_TIME'));
        Cache::put('countProducts', ProductQueries::countAll(), env('CACHE_TIME'));
        Cache::put('countTasks', TaskQueries::countAll(), env('CACHE_TIME'));
        Cache::put('countSales', SaleQueries::countAll(), env('CACHE_TIME'));
        Cache::put('deactivatedCompanies', CompanyQueries::getDeactivated(), env('CACHE_TIME'));
        Cache::put('todayIncome', $this->calculateCashService->loadCountTodayIncome(), env('CACHE_TIME'));
        Cache::put('yesterdayIncome', $this->calculateCashService->loadCountYesterdayIncome(), env('CACHE_TIME'));
        Cache::put('cashTurnover', $this->calculateCashService->loadCountCashTurnover(), env('CACHE_TIME'));
        Cache::put('countAllRowsInDb', $this->calculateCashService->loadCountAllRowsInDb(), env('CACHE_TIME'));
        Cache::put('countSystemLogs', SystemLogQueries::countAll(), env('CACHE_TIME'));
        Cache::put('companiesInLatestMonth', $this->companiesService->loadCompaniesInLatestMonth(), env('CACHE_TIME'));
        Cache::put('employeesInLatestMonth', $this->employeesService->loadEmployeesInLatestMonth(), env('CACHE_TIME'));
        Cache::put('deactivatedEmployees', EmployeeQueries::getDeactivated(), env('CACHE_TIME'));
        Cache::put('deactivatedDeals', DealQueries::getDeactivated(), env('CACHE_TIME'));
        Cache::put('dealsInLatestMonth', $this->dealsService->loadDealsInLatestMonth(), env('CACHE_TIME'));
        Cache::put('completedTasks', $this->tasksService->loadCompletedTasks(), env('CACHE_TIME'));
        Cache::put('uncompletedTasks', $this->tasksService->loadUncompletedTasks(), env('CACHE_TIME'));

        //loading circle
        Cache::put('loadingCircle', SettingQueries::getSettingValue('loading_circle'), env('CACHE_TIME'));

        // currency
        Cache::put('currency', SettingQueries::getSettingValue('currency'), env('CACHE_TIME'));

        // last deploy time and version
        Cache::put('lastDeployTime', SettingQueries::getSettingValue('last_deploy_time'), env('CACHE_TIME'));
        Cache::put('lastDeployVersion', SettingQueries::getSettingValue('last_deploy_version'), env('CACHE_TIME'));
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
