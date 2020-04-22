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

Route::get('login', 'CRM\AdminController@showLoginForm')->name('login');
Route::post('login/process', 'CRM\AdminController@processLoginAdmin')->name('login/process');
Route::get('logout', 'CRM\AdminController@logout')->name('logout');
Route::get('password/reset', 'CRM\AdminController@renderChangePasswordView')->name('password-reset');
Route::post('password/reset/process', 'CRM\AdminController@processChangePassword')->name('password-process');

Route::get('/', 'DashboardController@index')->name('home');
Route::get('/', 'DashboardController@index');

Route::get('/reload-info', 'DashboardController@processReloadInformation')->name('reload-info');

Route::group(['prefix' => 'clients'], function () {
    Route::get('/', 'CRM\ClientController@processListOfClients')->name('clients');
    Route::get('form/create', 'CRM\ClientController@processRenderCreateForm')->name('processRenderCreateForm');
    Route::get('form/update/{clientId}', 'CRM\ClientController@processRenderUpdateForm')->name('processRenderUpdateForm');
    Route::get('view/{clientId}', 'CRM\ClientController@processShowClientDetails')->name('viewClientDetails');
    Route::post('store', 'CRM\ClientController@processStoreClient')->name('processStoreClient');
    Route::put('update/{clientId}', 'CRM\ClientController@processUpdateClient')->name('processUpdateClient');
    Route::delete('delete/{clientId}', 'CRM\ClientController@processDeleteClient')->name('processDeleteClient');
    Route::get('set-active/{id}/{value}', 'CRM\ClientController@processClientSetIsActive')->name('processSetIsActive');
});

Route::group(['prefix' => 'companies'], function () {
    Route::get('/', 'CRM\CompaniesController@processListOfCompanies')->name('companies');
    Route::get('form/create', 'CRM\CompaniesController@processRenderCreateForm')->name('processRenderCreateForm');
    Route::get('form/update/{clientId}', 'CRM\CompaniesController@processRenderUpdateForm')->name('processRenderUpdateForm');
    Route::get('view/{clientId}', 'CRM\CompaniesController@processViewCompanyDetails')->name('viewCompaniesDetails');
    Route::post('store', 'CRM\CompaniesController@processStoreCompany')->name('processStoreCompanies');
    Route::put('update/{employeeId}', 'CRM\CompaniesController@processUpdateCompany')->name('processUpdateCompanies');
    Route::delete('delete/{clientId}', 'CRM\CompaniesController@processDeleteCompany')->name('processDeleteCompanies');
    Route::get('set-active/{id}/{value}', 'CRM\CompaniesController@processCompanySetIsActive')->name('processSetIsActive');
});

Route::group(['prefix' => 'deals'], function () {
    Route::get('/', 'CRM\DealsController@processListOfDeals')->name('deals');
    Route::get('form/create', 'CRM\DealsController@processRenderCreateForm')->name('processRenderCreateForm');
    Route::get('form/update/{clientId}', 'CRM\DealsController@processRenderUpdateForm')->name('processRenderUpdateForm');
    Route::get('view/{clientId}', 'CRM\DealsController@processShowDealsDetails')->name('viewDealsDetails');
    Route::post('store', 'CRM\DealsController@processStoreDeal')->name('processStoreDeal');
    Route::put('update/{employeeId}', 'CRM\DealsController@processUpdateDeal')->name('processUpdateDeal');
    Route::delete('delete/{clientId}', 'CRM\DealsController@processDeleteDeal')->name('processDeleteDeal');
    Route::get('set-active/{id}/{value}', 'CRM\DealsController@processSetIsActive')->name('processSetIsActive');
    Route::post('store-terms', 'CRM\DealsController@processStoreDealTerms')->name('processStoreDealTerms');
    Route::post('terms/generate-pdf', 'CRM\DealsController@processGenerateDealTermsInPDF');
    Route::delete('terms/delete', 'CRM\DealsController@processDeleteDealTerm')->name('processDeleteDealTerm');
});

Route::group(['prefix' => 'employees'], function () {
    Route::get('/', 'CRM\EmployeesController@processListOfEmployees')->name('employees');
    Route::get('form/create', 'CRM\EmployeesController@processRenderCreateForm')->name('processRenderCreateForm');
    Route::get('form/update/{clientId}', 'CRM\EmployeesController@processRenderUpdateForm')->name('processRenderUpdateForm');
    Route::get('view/{clientId}', 'CRM\EmployeesController@processShowEmployeeDetails')->name('viewEmployeeDetails');
    Route::post('store', 'CRM\EmployeesController@processStoreEmployee')->name('processStoreEmployee');
    Route::put('update/{employeeId}', 'CRM\EmployeesController@processUpdateEmployee')->name('processUpdateEmployee');
    Route::delete('delete/{clientId}', 'CRM\EmployeesController@processDeleteEmployee')->name('processDeleteEmployee');
    Route::get('set-active/{id}/{value}', 'CRM\EmployeesController@processEmployeeSetIsActive')->name('processSetIsActive');
});

Route::group(['prefix' => 'tasks'], function () {
    Route::get('/', 'CRM\TasksController@processListOfTasks')->name('tasks');
    Route::get('form/create', 'CRM\TasksController@processRenderCreateForm')->name('processRenderCreateForm');
    Route::get('form/update/{clientId}', 'CRM\TasksController@processRenderUpdateForm')->name('processRenderUpdateForm');
    Route::get('view/{clientId}', 'CRM\TasksController@processShowTasksDetails')->name('viewTasksDetails');
    Route::post('store', 'CRM\TasksController@processStoreTask')->name('processStoreTask');
    Route::put('update/{employeeId}', 'CRM\TasksController@processUpdateTask')->name('processUpdateTask');
    Route::delete('delete/{clientId}', 'CRM\TasksController@processDeleteTask')->name('processDeleteTask');
    Route::get('set-active/{id}/{value}', 'CRM\TasksController@processTaskSetIsActive')->name('processSetIsActive');
    Route::get('/completed/{id}', 'CRM\TasksController@processSetTaskToCompleted')->name('completeTask');
    Route::get('/uncompleted/{id}', 'CRM\TasksController@processSetTaskToUnCompleted')->name('processSetTaskToUnCompleted');
});

Route::group(['prefix' => 'sales'], function () {
    Route::get('/', 'CRM\SalesController@processListOfSales')->name('sales');
    Route::get('form/create', 'CRM\SalesController@processRenderCreateForm')->name('processRenderCreateForm');
    Route::get('form/update/{clientId}', 'CRM\SalesController@processRenderUpdateForm')->name('processRenderUpdateForm');
    Route::get('view/{clientId}', 'CRM\SalesController@processShowSalesDetails')->name('viewSalesDetails');
    Route::post('store', 'CRM\SalesController@processStoreSale')->name('processStoreSale');
    Route::put('update/{employeeId}', 'CRM\SalesController@processUpdateSale')->name('processUpdateSale');
    Route::delete('delete/{clientId}', 'CRM\SalesController@processDeleteSale')->name('processDeleteSale');
    Route::get('set-active/{id}/{value}', 'CRM\SalesController@processSaleSetIsActive')->name('processSetIsActive');
});

Route::group(['prefix' => 'products'], function () {
    Route::get('/', 'CRM\ProductsController@processListOfProducts')->name('products');
    Route::get('form/create', 'CRM\ProductsController@processRenderCreateForm')->name('processRenderCreateForm');
    Route::get('form/update/{clientId}', 'CRM\ProductsController@processRenderUpdateForm')->name('processRenderUpdateForm');
    Route::get('view/{clientId}', 'CRM\ProductsController@processShowProductsDetails')->name('viewProductsDetails');
    Route::post('store', 'CRM\ProductsController@processStoreProduct')->name('processStoreProduct');
    Route::put('update/{employeeId}', 'CRM\ProductsController@processUpdateProduct')->name('processUpdateProduct');
    Route::delete('delete/{clientId}', 'CRM\ProductsController@processDeleteProduct')->name('processDeleteProduct');
    Route::get('set-active/{id}/{value}', 'CRM\ProductsController@processProductSetIsActive')->name('processSetIsActive');
});

Route::group(['prefix' => 'finances'], function () {
    Route::get('/', 'CRM\FinancesController@processListOfFinances')->name('finances');
    Route::get('form/create', 'CRM\FinancesController@processRenderCreateForm')->name('processRenderCreateForm');
    Route::get('form/update/{clientId}', 'CRM\FinancesController@processRenderUpdateForm')->name('processRenderUpdateForm');
    Route::get('view/{clientId}', 'CRM\FinancesController@processShowFinancesDetails')->name('viewFinancesDetails');
    Route::post('store', 'CRM\FinancesController@processStoreFinance')->name('processStoreFinance');
    Route::put('update/{employeeId}', 'CRM\FinancesController@processUpdateFinance')->name('processUpdateFinance');
    Route::delete('delete/{clientId}', 'CRM\FinancesController@processDeleteFinance')->name('processDeleteFinance');
    Route::get('set-active/{id}/{value}', 'CRM\FinancesController@processFinanceSetIsActive')->name('processSetIsActive');
});

Route::group(['prefix' => 'settings'], function () {
    Route::get('/', 'CRM\SettingsController@processListOfSettings')->name('settings');
    Route::put('update', 'CRM\SettingsController@processUpdateSettings')->name('processUpdateSettings');
});
