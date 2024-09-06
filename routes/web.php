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

use App\Http\Controllers\CRM\AdminController;
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

Route::get('login', [AdminController::class, 'showLoginForm'])->name('login');
Route::post('login/process', [AdminController::class, 'processLoginAdmin'])->name('login.process');
Route::get('logout', [AdminController::class, 'logout'])->name('logout');
Route::get('password/reset', [AdminController::class, 'renderChangePasswordView'])->name('password.reset');
Route::post('password/reset/process', [AdminController::class, 'processChangePassword'])->name('password.reset.process');

Route::get('/', [DashboardController::class, 'index'])->name('home');
Route::get('/reload-info', [DashboardController::class, 'processReloadInformation'])->name('reload.info');

Route::group(['prefix' => 'clients'], function () {
    Route::get('/', [ClientController::class, 'processListOfClients'])->name('clients.index');
    Route::get('form/create', [ClientController::class, 'processRenderCreateForm'])->name('clients.create');
    Route::get('form/update/{client}', [ClientController::class, 'processRenderUpdateForm'])->name('clients.update.form');
    Route::get('view/{client}', [ClientController::class, 'processShowClientDetails'])->name('clients.view');
    Route::post('store', [ClientController::class, 'processStoreClient'])->name('clients.store');
    Route::put('update/{client}', [ClientController::class, 'processUpdateClient'])->name('clients.update');
    Route::delete('delete/{client}', [ClientController::class, 'processDeleteClient'])->name('clients.delete');
    Route::get('set-active/{client}/{value}', [ClientController::class, 'processClientSetIsActive'])->name('clients.set.active');
});

Route::group(['prefix' => 'companies'], function () {
    Route::get('/', [CompaniesController::class, 'processListOfCompanies'])->name('companies.index');
    Route::get('form/create', [CompaniesController::class, 'processRenderCreateForm'])->name('companies.create');
    Route::get('form/update/{company}', [CompaniesController::class, 'processRenderUpdateForm'])->name('companies.update.form');
    Route::get('view/{company}', [CompaniesController::class, 'processViewCompanyDetails'])->name('companies.view');
    Route::post('store', [CompaniesController::class, 'processStoreCompany'])->name('companies.store');
    Route::put('update/{company}', [CompaniesController::class, 'processUpdateCompany'])->name('companies.update');
    Route::delete('delete/{company}', [CompaniesController::class, 'processDeleteCompany'])->name('companies.delete');
    Route::get('set-active/{company}/{value}', [CompaniesController::class, 'processCompanySetIsActive'])->name('companies.set.active');
});

Route::group(['prefix' => 'deals'], function () {
    Route::get('/', [DealsController::class, 'processListOfDeals'])->name('deals.index');
    Route::get('form/create', [DealsController::class, 'processRenderCreateForm'])->name('deals.create');
    Route::get('form/update/{deal}', [DealsController::class, 'processRenderUpdateForm'])->name('deals.update.form');
    Route::get('view/{deal}', [DealsController::class, 'processShowDealsDetails'])->name('deals.view');
    Route::post('store', [DealsController::class, 'processStoreDeal'])->name('deals.store');
    Route::put('update/{deal}', [DealsController::class, 'processUpdateDeal'])->name('deals.update');
    Route::delete('delete/{deal}', [DealsController::class, 'processDeleteDeal'])->name('deals.delete');
    Route::get('set-active/{deal}/{value}', [DealsController::class, 'processSetIsActive'])->name('deals.set.active');
    Route::post('store-terms/{deal}', [DealsController::class, 'processStoreDealTerms'])->name('deals.terms.store');
    Route::delete('terms/delete/{dealTerm}', [DealsController::class, 'processDeleteDealTerm'])->name('deals.terms.delete');
    Route::post('terms/{dealTerm}/generate-pdf/{deal}', [DealsController::class, 'processGenerateDealTermsInPDF'])->name('deals.terms.generate-pdf');
});

Route::group(['prefix' => 'employees'], function () {
    Route::get('/', [EmployeesController::class, 'processListOfEmployees'])->name('employees.index');
    Route::get('form/create', [EmployeesController::class, 'processRenderCreateForm'])->name('employees.create');
    Route::get('form/update/{employee}', [EmployeesController::class, 'processRenderUpdateForm'])->name('employees.update.form');
    Route::get('view/{employee}', [EmployeesController::class, 'processShowEmployeeDetails'])->name('employees.view');
    Route::post('store', [EmployeesController::class, 'processStoreEmployee'])->name('employees.store');
    Route::put('update/{employee}', [EmployeesController::class, 'processUpdateEmployee'])->name('employees.update');
    Route::delete('delete/{employee}', [EmployeesController::class, 'processDeleteEmployee'])->name('employees.delete');
    Route::get('set-active/{employee}/{value}', [EmployeesController::class, 'processEmployeeSetIsActive'])->name('employees.set.active');
});

Route::group(['prefix' => 'tasks'], function () {
    Route::get('/', [TasksController::class, 'processListOfTasks'])->name('tasks.index');
    Route::get('form/create', [TasksController::class, 'processRenderCreateForm'])->name('tasks.create');
    Route::get('form/update/{task}', [TasksController::class, 'processRenderUpdateForm'])->name('tasks.update.form');
    Route::get('view/{task}', [TasksController::class, 'processShowTasksDetails'])->name('tasks.view');
    Route::post('store', [TasksController::class, 'processStoreTask'])->name('tasks.store');
    Route::put('update/{task}', [TasksController::class, 'processUpdateTask'])->name('tasks.update');
    Route::delete('delete/{task}', [TasksController::class, 'processDeleteTask'])->name('tasks.delete');
    Route::get('set-active/{task}/{value}', [TasksController::class, 'processTaskSetIsActive'])->name('tasks.set.active');
    Route::get('completed/{task}/{value}', [TasksController::class, 'processSetTaskToCompleted'])->name('tasks.complete');
});

Route::group(['prefix' => 'sales'], function () {
    Route::get('/', [SalesController::class, 'processListOfSales'])->name('sales.index');
    Route::get('form/create', [SalesController::class, 'processRenderCreateForm'])->name('sales.create');
    Route::get('form/update/{sale}', [SalesController::class, 'processRenderUpdateForm'])->name('sales.update.form');
    Route::get('view/{sale}', [SalesController::class, 'processShowSalesDetails'])->name('sales.view');
    Route::post('store', [SalesController::class, 'processStoreSale'])->name('sales.store');
    Route::put('update/{sale}', [SalesController::class, 'processUpdateSale'])->name('sales.update');
    Route::delete('delete/{sale}', [SalesController::class, 'processDeleteSale'])->name('sales.delete');
    Route::get('set-active/{sale}/{value}', [SalesController::class, 'processSaleSetIsActive'])->name('sales.set.active');

});

Route::group(['prefix' => 'products'], function () {
    Route::get('/', [ProductsController::class, 'processListOfProducts'])->name('products.index');
    Route::get('form/create', [ProductsController::class, 'processRenderCreateForm'])->name('products.create');
    Route::get('form/update/{product}', [ProductsController::class, 'processRenderUpdateForm'])->name('products.update.form');
    Route::get('view/{product}', [ProductsController::class, 'processShowProductsDetails'])->name('products.view');
    Route::post('store', [ProductsController::class, 'processStoreProduct'])->name('products.store');
    Route::put('update/{product}', [ProductsController::class, 'processUpdateProduct'])->name('products.update');
    Route::delete('delete/{product}', [ProductsController::class, 'processDeleteProduct'])->name('products.delete');
    Route::get('set-active/{product}/{value}', [ProductsController::class, 'processProductSetIsActive'])->name('products.set.active');
});

Route::group(['prefix' => 'finances'], function () {
    Route::get('/', [FinancesController::class, 'processListOfFinances'])->name('finances.index');
    Route::get('form/create', [FinancesController::class, 'processRenderCreateForm'])->name('finances.create');
    Route::get('form/update/{finance}', [FinancesController::class, 'processRenderUpdateForm'])->name('finances.update.form');
    Route::get('view/{finance}', [FinancesController::class, 'processShowFinancesDetails'])->name('finances.view');
    Route::post('store', [FinancesController::class, 'processStoreFinance'])->name('finances.store');
    Route::put('update/{finance}', [FinancesController::class, 'processUpdateFinance'])->name('finances.update');
    Route::delete('delete/{finance}', [FinancesController::class, 'processDeleteFinance'])->name('finances.delete');
    Route::get('set-active/{finance}/{value}', [FinancesController::class, 'processFinanceSetIsActive'])->name('finances.set.active');
});

Route::group(['prefix' => 'settings'], function () {
    Route::get('/', [SettingsController::class, 'processListOfSettings'])->name('settings.index');
    Route::put('update', [SettingsController::class, 'processUpdateSettings'])->name('settings.update');
});
