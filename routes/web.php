<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\CRM\AuthController;
use App\Http\Controllers\CRM\ClientController;
use App\Http\Controllers\CRM\CompaniesController;
use App\Http\Controllers\CRM\DealsController;
use App\Http\Controllers\CRM\EmployeesController;
use App\Http\Controllers\CRM\FinancesController;
use App\Http\Controllers\CRM\ProductsController;
use App\Http\Controllers\CRM\SalesController;
use App\Http\Controllers\CRM\SettingsController;
use App\Http\Controllers\CRM\TasksController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login/process', [AuthController::class, 'processLoginAdmin'])->name('login.process');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('password/reset', [AuthController::class, 'renderChangePasswordView'])->name('password.reset');
Route::post('password/reset/process', [AuthController::class, 'processChangePassword'])->name('password.reset.process');

Route::get('/', [DashboardController::class, 'index'])->name('home');
Route::get('/reload-info', [DashboardController::class, 'processReloadInformation'])->name('reload.info')->middleware('auth');

Route::group(['prefix' => 'clients', 'middleware' => 'auth'], function () {
    Route::get('/', [ClientController::class, 'processListOfClients'])->name('clients.index');
    Route::get('create', [ClientController::class, 'processRenderCreateForm'])->name('clients.create.form');
    Route::get('update/{client}', [ClientController::class, 'processRenderUpdateForm'])->name('clients.update.form');
    Route::get('view/{client}', [ClientController::class, 'processShowClientDetails'])->name('clients.view');
    Route::post('store', [ClientController::class, 'processStoreClient'])->name('clients.store');
    Route::put('update/{client}', [ClientController::class, 'processUpdateClient'])->name('clients.update');
    Route::delete('delete/{client}', [ClientController::class, 'processDeleteClient'])->name('clients.delete');
    Route::post('set-active/{client}', [ClientController::class, 'processClientSetIsActive'])->name('clients.set.active');
});

Route::group(['prefix' => 'companies', 'middleware' => 'auth'], function () {
    Route::get('/', [CompaniesController::class, 'processListOfCompanies'])->name('companies.index');
    Route::get('create', [CompaniesController::class, 'processRenderCreateForm'])->name('companies.create.form');
    Route::get('update/{company}', [CompaniesController::class, 'processRenderUpdateForm'])->name('companies.update.form');
    Route::get('view/{company}', [CompaniesController::class, 'processViewCompanyDetails'])->name('companies.view');
    Route::post('store', [CompaniesController::class, 'processStoreCompany'])->name('companies.store');
    Route::put('update/{company}', [CompaniesController::class, 'processUpdateCompany'])->name('companies.update');
    Route::delete('delete/{company}', [CompaniesController::class, 'processDeleteCompany'])->name('companies.delete');
    Route::post('set-active/{company}', [CompaniesController::class, 'processCompanySetIsActive'])->name('companies.set.active');
});

Route::group(['prefix' => 'deals', 'middleware' => 'auth'], function () {
    Route::get('/', [DealsController::class, 'processListOfDeals'])->name('deals.index');
    Route::get('create', [DealsController::class, 'processRenderCreateForm'])->name('deals.create.form');
    Route::get('update/{deal}', [DealsController::class, 'processRenderUpdateForm'])->name('deals.update.form');
    Route::get('view/{deal}', [DealsController::class, 'processShowDealsDetails'])->name('deals.view');
    Route::post('store', [DealsController::class, 'processStoreDeal'])->name('deals.store');
    Route::put('update/{deal}', [DealsController::class, 'processUpdateDeal'])->name('deals.update');
    Route::delete('delete/{deal}', [DealsController::class, 'processDeleteDeal'])->name('deals.delete');
    Route::post('set-active/{deal}', [DealsController::class, 'processSetIsActive'])->name('deals.set.active');
    Route::get('create-deal-term/{deal}', [DealsController::class, 'processRenderTermCreateForm'])->name('deals-terms.create.form');
    Route::post('store-terms/{deal}', [DealsController::class, 'processStoreDealTerms'])->name('deals.terms.store');
    Route::delete('terms/delete/{dealTerm}', [DealsController::class, 'processDeleteDealTerm'])->name('deals.terms.delete');
    Route::post('terms/{dealTerm}/generate-pdf/{deal}', [DealsController::class, 'processGenerateDealTermsInPDF'])->name('deals.terms.generate-pdf');
});

Route::group(['prefix' => 'employees', 'middleware' => 'auth'], function () {
    Route::get('/', [EmployeesController::class, 'processListOfEmployees'])->name('employees.index');
    Route::get('create', [EmployeesController::class, 'processRenderCreateForm'])->name('employees.create.form');
    Route::get('update/{employee}', [EmployeesController::class, 'processRenderUpdateForm'])->name('employees.update.form');
    Route::get('view/{employee}', [EmployeesController::class, 'processShowEmployeeDetails'])->name('employees.view');
    Route::post('store', [EmployeesController::class, 'processStoreEmployee'])->name('employees.store');
    Route::put('update/{employee}', [EmployeesController::class, 'processUpdateEmployee'])->name('employees.update');
    Route::delete('delete/{employee}', [EmployeesController::class, 'processDeleteEmployee'])->name('employees.delete');
    Route::post('set-active/{employee}', [EmployeesController::class, 'processEmployeeSetIsActive'])->name('employees.set.active');
});

Route::group(['prefix' => 'tasks', 'middleware' => 'auth'], function () {
    Route::get('/', [TasksController::class, 'processListOfTasks'])->name('tasks.index');
    Route::get('create', [TasksController::class, 'processRenderCreateForm'])->name('tasks.create.form');
    Route::get('update/{task}', [TasksController::class, 'processRenderUpdateForm'])->name('tasks.update.form');
    Route::get('view/{task}', [TasksController::class, 'processShowTasksDetails'])->name('tasks.view');
    Route::post('store', [TasksController::class, 'processStoreTask'])->name('tasks.store');
    Route::put('update/{task}', [TasksController::class, 'processUpdateTask'])->name('tasks.update');
    Route::delete('delete/{task}', [TasksController::class, 'processDeleteTask'])->name('tasks.delete');
    Route::post('set-active/{task}', [TasksController::class, 'processTaskSetIsActive'])->name('tasks.set.active');
    Route::patch('completed/{task}', [TasksController::class, 'processSetTaskToCompleted'])->name('tasks.complete');
});

Route::group(['prefix' => 'sales', 'middleware' => 'auth'], function () {
    Route::get('/', [SalesController::class, 'processListOfSales'])->name('sales.index');
    Route::get('create', [SalesController::class, 'processRenderCreateForm'])->name('sales.create.form');
    Route::get('update/{sale}', [SalesController::class, 'processRenderUpdateForm'])->name('sales.update.form');
    Route::get('view/{sale}', [SalesController::class, 'processShowSalesDetails'])->name('sales.view');
    Route::post('store', [SalesController::class, 'processStoreSale'])->name('sales.store');
    Route::put('update/{sale}', [SalesController::class, 'processUpdateSale'])->name('sales.update');
    Route::delete('delete/{sale}', [SalesController::class, 'processDeleteSale'])->name('sales.delete');
    Route::post('set-active/{sale}', [SalesController::class, 'processSaleSetIsActive'])->name('sales.set.active');

});

Route::group(['prefix' => 'products', 'middleware' => 'auth'], function () {
    Route::get('/', [ProductsController::class, 'processListOfProducts'])->name('products.index');
    Route::get('create', [ProductsController::class, 'processRenderCreateForm'])->name('products.create.form');
    Route::get('update/{product}', [ProductsController::class, 'processRenderUpdateForm'])->name('products.update.form');
    Route::get('view/{product}', [ProductsController::class, 'processShowProductsDetails'])->name('products.view');
    Route::post('store', [ProductsController::class, 'processStoreProduct'])->name('products.store');
    Route::put('update/{product}', [ProductsController::class, 'processUpdateProduct'])->name('products.update');
    Route::delete('delete/{product}', [ProductsController::class, 'processDeleteProduct'])->name('products.delete');
    Route::post('set-active/{product}', [ProductsController::class, 'processProductSetIsActive'])->name('products.set.active');
});

Route::group(['prefix' => 'finances', 'middleware' => 'auth'], function () {
    Route::get('/', [FinancesController::class, 'processListOfFinances'])->name('finances.index');
    Route::get('create', [FinancesController::class, 'processRenderCreateForm'])->name('finances.create.form');
    Route::get('update/{finance}', [FinancesController::class, 'processRenderUpdateForm'])->name('finances.update.form');
    Route::get('view/{finance}', [FinancesController::class, 'processShowFinancesDetails'])->name('finances.view');
    Route::post('store', [FinancesController::class, 'processStoreFinance'])->name('finances.store');
    Route::put('update/{finance}', [FinancesController::class, 'processUpdateFinance'])->name('finances.update');
    Route::delete('delete/{finance}', [FinancesController::class, 'processDeleteFinance'])->name('finances.delete');
    Route::post('set-active/{finance}', [FinancesController::class, 'processFinanceSetIsActive'])->name('finances.set.active');
});

Route::group(['prefix' => 'settings', 'middleware' => 'auth'], function () {
    Route::get('/', [SettingsController::class, 'processListOfSettings'])->name('settings.index');
    Route::put('update', [SettingsController::class, 'processUpdateSettings'])->name('settings.update');
});
