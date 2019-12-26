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

Route::get('/', 'DashboardController@index')->name('home');
Route::get('/', 'DashboardController@index');

Route::group(['prefix' => 'clients'], function () {
    Route::get('/', 'CRM\ClientController@processListOfClients')->name('clients');
    Route::get('form/create', 'CRM\ClientController@showCreateForm')->name('showCreateForm');
    Route::get('form/update/{clientId}', 'CRM\ClientController@showUpdateForm')->name('showUpdateForm');
    Route::get('view/{clientId}', 'CRM\ClientController@viewClientDetails')->name('viewClientDetails');
    Route::post('store', 'CRM\ClientController@processCreateClient')->name('processCreateClient');
    Route::put('update/{clientId}', 'CRM\ClientController@processUpdateClient')->name('processUpdateClient');
    Route::delete('delete/{clientId}', 'CRM\ClientController@processDeleteClient')->name('processDeleteClient');
    Route::get('set-active/{id}/{value}', 'CRM\ClientController@processSetIsActive')->name('processSetIsActive');
});

Route::group(['prefix' => 'companies'], function () {
    Route::get('/', 'CRM\CompaniesController@processListOfCompanies')->name('companies');
    Route::get('form/create', 'CRM\CompaniesController@showCreateForm')->name('showCreateForm');
    Route::get('form/update/{clientId}', 'CRM\CompaniesController@showUpdateForm')->name('showUpdateForm');
    Route::get('view/{clientId}', 'CRM\CompaniesController@viewCompaniesDetails')->name('viewCompaniesDetails');
    Route::post('store', 'CRM\CompaniesController@processCreateCompanies')->name('processCreateCompanies');
    Route::put('update/{employeeId}', 'CRM\CompaniesController@processUpdateCompanies')->name('processUpdateCompanies');
    Route::delete('delete/{clientId}', 'CRM\CompaniesController@processDeleteCompanies')->name('processDeleteCompanies');
    Route::get('set-active/{id}/{value}', 'CRM\CompaniesController@processSetIsActive')->name('processSetIsActive');
});

Route::group(['prefix' => 'deals'], function () {
    Route::get('/', 'CRM\DealsController@processListOfDeals')->name('deals');
    Route::get('form/create', 'CRM\DealsController@showCreateForm')->name('showCreateForm');
    Route::get('form/update/{clientId}', 'CRM\DealsController@showUpdateForm')->name('showUpdateForm');
    Route::get('view/{clientId}', 'CRM\DealsController@viewDealsDetails')->name('viewDealsDetails');
    Route::post('store', 'CRM\DealsController@processCreateDeals')->name('processCreateDeals');
    Route::put('update/{employeeId}', 'CRM\DealsController@processUpdateDeals')->name('processUpdateDeals');
    Route::delete('delete/{clientId}', 'CRM\DealsController@processDeleteDeals')->name('processDeleteDeals');
    Route::get('set-active/{id}/{value}', 'CRM\DealsController@processSetIsActive')->name('processSetIsActive');
});

Route::group(['prefix' => 'employees'], function () {
    Route::get('/', 'CRM\EmployeesController@processListOfEmployees')->name('employees');
    Route::get('form/create', 'CRM\EmployeesController@showCreateForm')->name('showCreateForm');
    Route::get('form/update/{clientId}', 'CRM\EmployeesController@showUpdateForm')->name('showUpdateForm');
    Route::get('view/{clientId}', 'CRM\EmployeesController@viewEmployeeDetails')->name('viewEmployeeDetails');
    Route::post('store', 'CRM\EmployeesController@processCreateEmployee')->name('processCreateEmployee');
    Route::put('update/{employeeId}', 'CRM\EmployeesController@processUpdateEmployee')->name('processUpdateEmployee');
    Route::delete('delete/{clientId}', 'CRM\EmployeesController@processDeleteEmployee')->name('processDeleteEmployee');
    Route::get('set-active/{id}/{value}', 'CRM\EmployeesController@processSetIsActive')->name('processSetIsActive');
});

Route::group(['prefix' => 'contacts'], function () {
    Route::get('/', 'CRM\ContactsController@processListOfContacts')->name('contacts');
    Route::get('form/create', 'CRM\ContactsController@showCreateForm')->name('showCreateForm');
    Route::get('form/update/{clientId}', 'CRM\ContactsController@showUpdateForm')->name('showUpdateForm');
    Route::get('view/{clientId}', 'CRM\ContactsController@viewContactsDetails')->name('viewContactsDetails');
    Route::post('store', 'CRM\ContactsController@processCreateContacts')->name('processCreateContacts');
    Route::put('update/{employeeId}', 'CRM\ContactsController@processUpdateContacts')->name('processUpdateContacts');
    Route::delete('delete/{clientId}', 'CRM\ContactsController@processDeleteContacts')->name('processDeleteContacts');
    Route::get('set-active/{id}/{value}', 'CRM\ContactsController@processSetIsActive')->name('processSetIsActive');
});

Route::group(['prefix' => 'tasks'], function () {
    Route::get('/', 'CRM\TasksController@processListOfTasks')->name('tasks');
    Route::get('form/create', 'CRM\TasksController@showCreateForm')->name('showCreateForm');
    Route::get('form/update/{clientId}', 'CRM\TasksController@showUpdateForm')->name('showUpdateForm');
    Route::get('view/{clientId}', 'CRM\TasksController@viewTasksDetails')->name('viewTasksDetails');
    Route::post('store', 'CRM\TasksController@processCreateTasks')->name('processCreateTasks');
    Route::put('update/{employeeId}', 'CRM\TasksController@processUpdateTasks')->name('processUpdateTasks');
    Route::delete('delete/{clientId}', 'CRM\TasksController@processDeleteTasks')->name('processDeleteTasks');
    Route::get('set-active/{id}/{value}', 'CRM\TasksController@processSetIsActive')->name('processSetIsActive');
    Route::get('/completed/{id}', 'CRM\TasksController@completedTask')->name('completeTask');
    Route::get('/uncompleted/{id}', 'CRM\TasksController@uncompletedTask')->name('uncompletedTask');
});

Route::group(['prefix' => 'sales'], function () {
    Route::get('/', 'CRM\SalesController@processListOfSales')->name('sales');
    Route::get('form/create', 'CRM\SalesController@showCreateForm')->name('showCreateForm');
    Route::get('form/update/{clientId}', 'CRM\SalesController@showUpdateForm')->name('showUpdateForm');
    Route::get('view/{clientId}', 'CRM\SalesController@viewSalesDetails')->name('viewSalesDetails');
    Route::post('store', 'CRM\SalesController@processCreateSales')->name('processCreateSales');
    Route::put('update/{employeeId}', 'CRM\SalesController@processUpdateSales')->name('processUpdateSales');
    Route::delete('delete/{clientId}', 'CRM\SalesController@processDeleteSales')->name('processDeleteSales');
    Route::get('set-active/{id}/{value}', 'CRM\SalesController@processSetIsActive')->name('processSetIsActive');
});

Route::group(['prefix' => 'products'], function () {
    Route::get('/', 'CRM\ProductsController@processListOfProducts')->name('products');
    Route::get('form/create', 'CRM\ProductsController@showCreateForm')->name('showCreateForm');
    Route::get('form/update/{clientId}', 'CRM\ProductsController@showUpdateForm')->name('showUpdateForm');
    Route::get('view/{clientId}', 'CRM\ProductsController@viewProductsDetails')->name('viewProductsDetails');
    Route::post('store', 'CRM\ProductsController@processCreateProducts')->name('processCreateProducts');
    Route::put('update/{employeeId}', 'CRM\ProductsController@processUpdateProducts')->name('processUpdateProducts');
    Route::delete('delete/{clientId}', 'CRM\ProductsController@processDeleteProducts')->name('processDeleteProducts');
    Route::get('set-active/{id}/{value}', 'CRM\ProductsController@processSetIsActive')->name('processSetIsActive');
});

Route::group(['prefix' => 'projects'], function () {
    Route::get('/', 'CRM\ProjectsController@processListOfProjects')->name('projects');
    Route::get('form/create', 'CRM\ProjectsController@showCreateForm')->name('showCreateForm');
    Route::get('form/update/{clientId}', 'CRM\ProjectsController@showUpdateForm')->name('showUpdateForm');
    Route::get('view/{clientId}', 'CRM\ProjectsController@viewProjectsDetails')->name('viewProjectsDetails');
    Route::post('store', 'CRM\ProjectsController@processCreateProjects')->name('processCreateProjects');
    Route::put('update/{employeeId}', 'CRM\ProjectsController@processUpdateProjects')->name('processUpdateProjects');
    Route::delete('delete/{clientId}', 'CRM\ProjectsController@processDeleteProjects')->name('processDeleteProjects');
    Route::get('set-active/{id}/{value}', 'CRM\ProjectsController@processSetIsActive')->name('processSetIsActive');
});

Route::group(['prefix' => 'finances'], function () {
    Route::get('/', 'CRM\FinancesController@processListOfFinances')->name('finances');
    Route::get('form/create', 'CRM\FinancesController@showCreateForm')->name('showCreateForm');
    Route::get('form/update/{clientId}', 'CRM\FinancesController@showUpdateForm')->name('showUpdateForm');
    Route::get('view/{clientId}', 'CRM\FinancesController@viewFinancesDetails')->name('viewFinancesDetails');
    Route::post('store', 'CRM\FinancesController@processCreateFinances')->name('processCreateFinances');
    Route::put('update/{employeeId}', 'CRM\FinancesController@processUpdateFinances')->name('processUpdateFinances');
    Route::delete('delete/{clientId}', 'CRM\FinancesController@processDeleteFinances')->name('processDeleteFinances');
    Route::get('set-active/{id}/{value}', 'CRM\FinancesController@processSetIsActive')->name('processSetIsActive');
});

Route::group(['prefix' => 'settings'], function () {
    Route::get('/', 'CRM\SettingsController@processListOfSettings')->name('settings');
    Route::get('form/create', 'CRM\SettingsController@showCreateForm')->name('showCreateForm');
    Route::get('form/update/{clientId}', 'CRM\SettingsController@showUpdateForm')->name('showUpdateForm');
    Route::get('view/{clientId}', 'CRM\SettingsController@viewSettingsDetails')->name('viewSettingsDetails');
    Route::post('store', 'CRM\SettingsController@processCreateSettings')->name('processCreateSettings');
    Route::put('update/{employeeId}', 'CRM\SettingsController@processUpdateSettings')->name('processUpdateSettings');
    Route::delete('delete/{clientId}', 'CRM\SettingsController@processDeleteSettings')->name('processDeleteSettings');
    Route::get('set-active/{id}/{value}', 'CRM\SettingsController@processSetIsActive')->name('processSetIsActive');
});
