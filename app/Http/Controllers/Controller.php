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
use App\Traits\Language;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, Language;

    public $companiesService;
    public $productsService;
    public $helpersFncService;
    public $clientService;
    public $employeesService;
    public $dealsService;
    public $financesService;
    public $tasksService;
    public $salesService;
    public $calculateCashService;
    public $systemLogsService;
    public $settingsService;

    public function __construct()
    {
        $this->companiesService = new CompaniesService();
        $this->productsService = new ProductsService();
        $this->helpersFncService = new HelpersFncService();
        $this->clientService = new ClientService();
        $this->employeesService = new EmployeesService();
        $this->dealsService = new DealsService();
        $this->financesService = new FinancesService();
        $this->tasksService = new TasksService();
        $this->salesService = new SalesService();
        $this->calculateCashService = new CalculateCashService();
        $this->systemLogsService = new SystemLogService();
        $this->settingsService = new SettingsService();

        $this->middleware('auth');
    }

    public function collectedData(bool $isDashboard = false)
    {
        if($isDashboard == true) {
            return [
                'dataWithAllTasks' => $this->helpersFncService->formatTasks(),
                'dataWithAllCompanies' => $this->companiesService->loadCompaniesByCreatedAt(),
                'dataWithAllProducts' => $this->productsService->loadProductsByCreatedAt(),
                'tasksGraphData' => $this->taskGraphData(),
                'itemsCountGraphData' => $this->itemsCountGraphData(),
                'countClients' => $this->clientService->countClients(),
                'deactivatedClients' => $this->clientService->loadDeactivatedClients(),
                'clientsInLatestMonth' => $this->clientService->loadClientsInLatestMonth(),
                'countCompanies' => $this->companiesService->loadCountCompanies(),
                'countEmployees' => $this->employeesService->loadCountEmployees(),
                'countDeals' => $this->dealsService->loadCountDeals(),
                'countFinances' => $this->financesService->loadCountFinances(),
                'countProducts' => $this->productsService->loadCountProducts(),
                'countTasks' => $this->tasksService->loadCountTasks(),
                'countSales' => $this->salesService->loadCountSales(),
                'deactivatedCompanies' => $this->companiesService->loadDeactivatedCompanies(),
                'todayIncome' => $this->calculateCashService->countTodayIncome(),
                'yesterdayIncome' => $this->calculateCashService->countYesterdayIncome(),
                'cashTurnover' => $this->calculateCashService->countCashTurnover(),
                'countAllRowsInDb' => $this->calculateCashService->countAllRowsInDb(),
                'countSystemLogs' => $this->systemLogsService->loadCountLogs(),
                'companiesInLatestMonth' => $this->companiesService->loadCompaniesInLatestMonth(),
                'employeesInLatestMonth' => $this->employeesService->loadEmployeesInLatestMonth(),
                'deactivatedEmployees' => $this->employeesService->loadDeactivatedEmployees(),
                'deactivatedDeals' => $this->dealsService->loadDeactivatedDeals(),
                'dealsInLatestMonth' => $this->dealsService->loadDealsInLatestMonth(),
                'completedTasks' => $this->tasksService->loadCompletedTasks(),
                'uncompletedTasks' => $this->tasksService->loadUncompletedTasks()
                ];
        } else {
            return [
                'countClients' => $this->clientService->countClients(),
                'countCompanies' => $this->companiesService->loadCountCompanies(),
                'countEmployees' => $this->employeesService->loadCountEmployees(),
                'countDeals' => $this->dealsService->loadCountDeals(),
                'countFinances' => $this->financesService->loadCountFinances(),
                'countProducts' => $this->productsService->loadCountProducts(),
                'countTasks' => $this->tasksService->loadCountTasks(),
                'countSales' => $this->salesService->loadCountSales(),
                'todayIncome' => $this->calculateCashService->countTodayIncome(),
                'yesterdayIncome' => $this->calculateCashService->countYesterdayIncome(),
                'cashTurnover' => $this->calculateCashService->countCashTurnover(),
                'countAllRowsInDb' => $this->calculateCashService->countAllRowsInDb(),
                'countSystemLogs' => $this->systemLogsService->loadCountLogs(),
                'inputText' => $this->getMessage('messages.InputText')
            ];
        }

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
