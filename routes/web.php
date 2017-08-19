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

/* Clients */
Route::get('/client/enable/{id}', 'CRM\ClientController@enable')->name('enable');
Route::get('/client/disable/{id}', 'CRM\ClientController@disable')->name('disable');
Route::resource('client', 'CRM\ClientController');

/* Companies */
Route::get('/companies/enable/{id}', 'CRM\CompaniesController@enable')->name('enable');
Route::get('/companies/disable/{id}', 'CRM\CompaniesController@disable')->name('disable');
Route::resource('companies', 'CRM\CompaniesController');

/* Deals */
Route::get('/deals/enable/{id}', 'CRM\DealsController@enable')->name('enable');
Route::get('/deals/disable/{id}', 'CRM\DealsController@disable')->name('disable');
Route::resource('deals', 'CRM\DealsController');

/* Employees */
Route::get('/employees/enable/{id}', 'CRM\EmployeesController@enable')->name('enable');
Route::get('/employees/disable/{id}', 'CRM\EmployeesController@disable')->name('disable');
Route::resource('employees', 'CRM\EmployeesController');


Route::get('/home', 'DashboardController@index')->name('home');
Route::get('/settings', 'CRM\SettingsController@index')->name('settings');
Route::get('/', 'DashboardController@index');
Route::get('/accounts', 'CRM\AccountsController@index')->name('accounts');
Route::get('/calendar', 'CRM\CalendarController@index')->name('calendar');
Route::get('/projects', 'CRM\ProjectsController@index')->name('projects');
Route::get('/products', 'CRM\ProductsController@index')->name('products');
Route::get('/category', 'CRM\CategoryController@index')->name('category');
Route::get('/job', 'CRM\JobController@index')->name('job');
Route::get('/contacts', 'CRM\ContactsController@index')->name('contacts');
Route::get('/deals', 'CRM\DealsController@index')->name('deals');
Route::get('/mailing', 'CRM\MailingController@index')->name('mailing');
Route::get('/employees', 'CRM\EmployeesController@index')->name('employees');
Route::get('/files', 'CRM\FilesController@index')->name('files');
Route::get('/invoices', 'CRM\InvoicesController@index')->name('invoices');
Route::get('/finances', 'CRM\FinancesController@index')->name('finances');
Route::get('/reports', 'CRM\ReportsController@index')->name('reports');
Route::get('/charts', 'CRM\ChartsController@index')->name('charts');
Route::get('/clients', 'CRM\ClientController@index')->name('clients');
Route::get('/companies', 'CRM\CompaniesController@index')->name('companies');
Route::get('/sales', 'CRM\SalesController@index')->name('sales');
Route::get('/tasks', 'CRM\TasksController@index')->name('tasks');

