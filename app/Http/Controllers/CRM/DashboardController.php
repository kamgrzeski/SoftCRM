<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Services\statisticsService;
use App\Services\ClientsService;
use App\Services\CompaniesService;
use App\Services\DealsService;
use App\Services\EmployeesService;
use App\Services\FinancesService;
use App\Services\ProductsService;
use App\Services\SalesService;
use App\Services\SettingsService;
use App\Services\SystemLogsService;
use App\Services\TasksService;

class DashboardController extends Controller
{
    public $companiesService;
    public $productsService;
    public $clientService;
    public $employeesService;
    public $dealsService;
    public $financesService;
    public $tasksService;
    public $salesService;
    public $statisticsService;
    public $systemLogsService;
    public $settingsService;

    public function __construct()
    {
        parent::__construct();
        $this->companiesService = new CompaniesService();
        $this->productsService = new ProductsService();
        $this->clientService = new ClientsService();
        $this->employeesService = new EmployeesService();
        $this->dealsService = new DealsService();
        $this->financesService = new FinancesService();
        $this->tasksService = new TasksService();
        $this->salesService = new SalesService();
        $this->statisticsService = new StatisticsService();
        $this->systemLogsService = new SystemLogsService();
        $this->settingsService = new SettingsService();
    }

    public function getContent() : array
    {
        return [
            'counts' => [
                'countClients' => $this->clientService->loadCountClients(),
                'countCompanies' => $this->companiesService->loadCountCompanies(),
                'countEmployees' => $this->employeesService->loadCountEmployees(),
                'countDeals' => $this->dealsService->loadCountDeals(),
                'countFinances' => $this->financesService->loadCountFinances(),
                'countProducts' => $this->productsService->loadCountProducts(),
                'countTasks' => $this->tasksService->loadCountTasks(),
                'countSales' => $this->salesService->loadCountSales(),
                'deactivatedClients' => $this->clientService->loadDeactivatedClients(),
                'clientsInLatestMonth' => $this->clientService->loadClientsInLatestMonth(),
                'deactivatedCompanies' => $this->companiesService->loadDeactivatedCompanies(),
                'deactivatedEmployees' => $this->employeesService->loadDeactivatedEmployees(),
                'deactivatedDeals' => $this->dealsService->loadDeactivatedDeals(),
                'dealsInLatestMonth' => $this->dealsService->loadDealsInLatestMonth(),
                'companiesInLatestMonth' => $this->companiesService->loadCompaniesInLatestMonth(),
                'employeesInLatestMonth' => $this->employeesService->loadEmployeesInLatestMonth(),
            ],
            'data' => [
                'dataWithAllCompanies' => $this->companiesService->loadCompanies(),
                'dataWithAllProducts' => $this->productsService->loadProducts(),
                'completedTasks' => $this->tasksService->loadCompletedTasks(),
                'uncompletedTasks' => $this->tasksService->loadUncompletedTasks(),
                'dataWithAllTasks' => $this->tasksService->loadTasks(),
            ],
            'statistics' => [
                'todayIncome' => $this->statisticsService->countTodayIncome(),
                'yesterdayIncome' => $this->statisticsService->countYesterdayIncome(),
                'cashTurnover' => $this->statisticsService->countCashTurnover(),
                'countSystemLogs' => $this->systemLogsService->loadCountLogs(),
                'countAllRowsInDb' => $this->statisticsService->countAllRowsInDb(),
            ],
        ];
    }
}
