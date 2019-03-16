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

Auth::routes();

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::group(['middleware' => ['auth']], function () {
    //
/* Clients */
Route::get('/client/set-active/{id}/{value}', 'CRM\ClientController@processSetIsActive')->name('processSetIsActive');
Route::resource('client', 'CRM\ClientController');

/* Companies */
Route::get('/companies/set-active/{id}/{value}', 'CRM\CompaniesController@processSetIsActive')->name('processSetIsActive');
Route::resource('companies', 'CRM\CompaniesController');

/* Deals */
Route::get('/deals/set-active/{id}/{value}', 'CRM\DealsController@processSetIsActive')->name('processSetIsActive');
Route::resource('deals', 'CRM\DealsController');

/* Employees */
Route::get('/employees/set-active/{id}/{value}', 'CRM\EmployeesController@processSetIsActive')->name('processSetIsActive');
Route::resource('employees', 'CRM\EmployeesController');

/* Contacts */
Route::resource('contacts', 'CRM\ContactsController');

/* Tasks */
Route::get('/tasks/set-active/{id}/{value}', 'CRM\TasksController@processSetIsActive')->name('processSetIsActive');
Route::resource('tasks', 'CRM\TasksController');
Route::get('/tasks/completed/{id}', 'CRM\TasksController@completedTask')->name('completeTask');
Route::get('/tasks/uncompleted/{id}', 'CRM\TasksController@uncompletedTask')->name('uncompletedTask');

/* Sales */
Route::get('/sales/set-active/{id}/{value}', 'CRM\SalesController@processSetIsActive')->name('processSetIsActive');
Route::resource('sales', 'CRM\SalesController');

/* Products */
Route::get('/products/set-active/{id}/{value}', 'CRM\ProductsController@processSetIsActive')->name('processSetIsActive');
Route::resource('products', 'CRM\ProductsController');

/* Projects */
Route::get('/projects/set-active/{id}/{value}', 'CRM\ProjectsController@processSetIsActive')->name('processSetIsActive');
Route::resource('projects', 'CRM\ProjectsController');

/* Finances */
Route::get('/finances/set-active/{id}/{value}', 'CRM\FinancesController@processSetIsActive')->name('processSetIsActive');
Route::resource('finances', 'CRM\FinancesController');

/* Settings */
Route::resource('settings', 'CRM\SettingsController');
Route::get('/settings', 'CRM\SettingsController@index')->name('settings');


Route::get('/', 'DashboardController@index')->name('home');
Route::get('/', 'DashboardController@index');
Route::get('/calendar', 'CRM\CalendarController@index')->name('calendar');
Route::get('/projects', 'CRM\ProjectsController@index')->name('projects');
Route::get('/products', 'CRM\ProductsController@index')->name('products');
Route::get('/category', 'CRM\CategoryController@index')->name('category');
Route::get('/contacts', 'CRM\ContactsController@index')->name('contacts');
Route::get('/deals', 'CRM\DealsController@index')->name('deals');
Route::get('/mailing', 'CRM\MailingController@index')->name('mailing');
Route::get('/employees', 'CRM\EmployeesController@index')->name('employees');
Route::get('/finances', 'CRM\FinancesController@index')->name('finances');
Route::get('/reports', 'CRM\ReportsController@index')->name('reports');
Route::get('/charts', 'CRM\ChartsController@index')->name('charts');
Route::get('/clients', 'CRM\ClientController@index')->name('clients');
Route::get('/companies', 'CRM\CompaniesController@index')->name('companies');
Route::get('/sales', 'CRM\SalesController@index')->name('sales');
Route::get('/tasks', 'CRM\TasksController@index')->name('tasks');

});