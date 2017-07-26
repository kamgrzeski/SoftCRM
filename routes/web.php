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

Route::get('/', function () {
    return view('index');
});

Auth::routes();

Route::get('/home', 'DashboardController@index')->name('home');
Route::get('/accounts', 'CRM\AccountsController@index')->name('accounts');
Route::get('/calendar', 'CRM\CalendarController@index')->name('calendar');
Route::get('/projects', 'CRM\ProjectsController@index')->name('projects');
Route::get('/products', 'CRM\ProductsController@index')->name('products');
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

