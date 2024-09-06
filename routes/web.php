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
    Route::get('form/update/{client}', 'CRM\ClientController@processRenderUpdateForm')->name('processRenderUpdateForm');
    Route::get('view/{client}', 'CRM\ClientController@processShowClientDetails')->name('viewClientDetails');
    Route::post('store', 'CRM\ClientController@processStoreClient')->name('processStoreClient');
    Route::put('update/{client}', 'CRM\ClientController@processUpdateClient')->name('processUpdateClient');
    Route::delete('delete/{client}', 'CRM\ClientController@processDeleteClient')->name('processDeleteClient');
    Route::get('set-active/{client}/{value}', 'CRM\ClientController@processClientSetIsActive')->name('processSetIsActive');
});

Route::group(['prefix' => 'companies'], function () {
    Route::get('/', 'CRM\CompaniesController@processListOfCompanies')->name('companies');
    Route::get('form/create', 'CRM\CompaniesController@processRenderCreateForm')->name('processRenderCreateForm');
    Route::get('form/update/{company}', 'CRM\CompaniesController@processRenderUpdateForm')->name('processRenderUpdateForm');
    Route::get('view/{company}', 'CRM\CompaniesController@processViewCompanyDetails')->name('viewCompaniesDetails');
    Route::post('store', 'CRM\CompaniesController@processStoreCompany')->name('processStoreCompanies');
    Route::put('update/{company}', 'CRM\CompaniesController@processUpdateCompany')->name('processUpdateCompanies');
    Route::delete('delete/{company}', 'CRM\CompaniesController@processDeleteCompany')->name('processDeleteCompanies');
    Route::get('set-active/{company}/{value}', 'CRM\CompaniesController@processCompanySetIsActive')->name('processSetIsActive');
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
    Route::get('form/update/{employee}', 'CRM\EmployeesController@processRenderUpdateForm')->name('processRenderUpdateForm');
    Route::get('view/{employee}', 'CRM\EmployeesController@processShowEmployeeDetails')->name('viewEmployeeDetails');
    Route::post('store', 'CRM\EmployeesController@processStoreEmployee')->name('processStoreEmployee');
    Route::put('update/{employee}', 'CRM\EmployeesController@processUpdateEmployee')->name('processUpdateEmployee');
    Route::delete('delete/{employee}', 'CRM\EmployeesController@processDeleteEmployee')->name('processDeleteEmployee');
    Route::get('set-active/{employee}/{value}', 'CRM\EmployeesController@processEmployeeSetIsActive')->name('processSetIsActive');
});

Route::group(['prefix' => 'tasks'], function () {
    Route::get('/', 'CRM\TasksController@processListOfTasks')->name('tasks');
    Route::get('form/create', 'CRM\TasksController@processRenderCreateForm')->name('processRenderCreateForm');
    Route::get('form/update/{task}', 'CRM\TasksController@processRenderUpdateForm')->name('processRenderUpdateForm');
    Route::get('view/{task}', 'CRM\TasksController@processShowTasksDetails')->name('viewTasksDetails');
    Route::post('store', 'CRM\TasksController@processStoreTask')->name('processStoreTask');
    Route::put('update/{task}', 'CRM\TasksController@processUpdateTask')->name('processUpdateTask');
    Route::delete('delete/{task}', 'CRM\TasksController@processDeleteTask')->name('processDeleteTask');
    Route::get('set-active/{task}/{value}', 'CRM\TasksController@processTaskSetIsActive')->name('processSetIsActive');
    Route::get('/completed/{task}/{value}', 'CRM\TasksController@processSetTaskToCompleted')->name('completeTask');
});

Route::group(['prefix' => 'sales'], function () {
    Route::get('/', 'CRM\SalesController@processListOfSales')->name('sales');
    Route::get('form/create', 'CRM\SalesController@processRenderCreateForm')->name('processRenderCreateForm');
    Route::get('form/update/{sale}', 'CRM\SalesController@processRenderUpdateForm')->name('processRenderUpdateForm');
    Route::get('view/{sale}', 'CRM\SalesController@processShowSalesDetails')->name('viewSalesDetails');
    Route::post('store', 'CRM\SalesController@processStoreSale')->name('processStoreSale');
    Route::put('update/{sale}', 'CRM\SalesController@processUpdateSale')->name('processUpdateSale');
    Route::delete('delete/{sale}', 'CRM\SalesController@processDeleteSale')->name('processDeleteSale');
    Route::get('set-active/{sale}/{value}', 'CRM\SalesController@processSaleSetIsActive')->name('processSetIsActive');
});

Route::group(['prefix' => 'products'], function () {
    Route::get('/', 'CRM\ProductsController@processListOfProducts')->name('products');
    Route::get('form/create', 'CRM\ProductsController@processRenderCreateForm')->name('processRenderCreateForm');
    Route::get('form/update/{product}', 'CRM\ProductsController@processRenderUpdateForm')->name('processRenderUpdateForm');
    Route::get('view/{product}', 'CRM\ProductsController@processShowProductsDetails')->name('viewProductsDetails');
    Route::post('store', 'CRM\ProductsController@processStoreProduct')->name('processStoreProduct');
    Route::put('update/{product}', 'CRM\ProductsController@processUpdateProduct')->name('processUpdateProduct');
    Route::delete('delete/{product}', 'CRM\ProductsController@processDeleteProduct')->name('processDeleteProduct');
    Route::get('set-active/{product}/{value}', 'CRM\ProductsController@processProductSetIsActive')->name('processSetIsActive');
});

Route::group(['prefix' => 'finances'], function () {
    Route::get('/', 'CRM\FinancesController@processListOfFinances')->name('finances');
    Route::get('form/create', 'CRM\FinancesController@processRenderCreateForm')->name('processRenderCreateForm');
    Route::get('form/update/{finance}', 'CRM\FinancesController@processRenderUpdateForm')->name('processRenderUpdateForm');
    Route::get('view/{finance}', 'CRM\FinancesController@processShowFinancesDetails')->name('viewFinancesDetails');
    Route::post('store', 'CRM\FinancesController@processStoreFinance')->name('processStoreFinance');
    Route::put('update/{finance}', 'CRM\FinancesController@processUpdateFinance')->name('processUpdateFinance');
    Route::delete('delete/{finance}', 'CRM\FinancesController@processDeleteFinance')->name('processDeleteFinance');
    Route::get('set-active/{finance}/{value}', 'CRM\FinancesController@processFinanceSetIsActive')->name('processSetIsActive');
});

Route::group(['prefix' => 'settings'], function () {
    Route::get('/', 'CRM\SettingsController@processListOfSettings')->name('settings');
    Route::put('update', 'CRM\SettingsController@processUpdateSettings')->name('processUpdateSettings');
});
