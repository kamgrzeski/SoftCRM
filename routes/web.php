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
Route::get('/client/set-active/{id}/{value}', 'CRM\ClientController@isActiveFunction')->name('isActiveFunction');
Route::resource('client', 'CRM\ClientController');
Route::post('client/search', ['as' => 'client/search',  'uses' => 'CRM\ClientController@search']);

/* Companies */
Route::get('/companies/set-active/{id}/{value}', 'CRM\CompaniesController@isActiveFunction')->name('isActiveFunction');
Route::resource('companies', 'CRM\CompaniesController');
Route::post('companies/search', ['as' => 'companies/search',  'uses' => 'CRM\CompaniesController@search']);

/* Deals */
Route::get('/deals/set-active/{id}/{value}', 'CRM\DealsController@isActiveFunction')->name('isActiveFunction');
Route::resource('deals', 'CRM\DealsController');
Route::post('deals/search', ['as' => 'deals/search',  'uses' => 'CRM\DealsController@search']);

/* Employees */
Route::get('/employees/set-active/{id}/{value}', 'CRM\EmployeesController@isActiveFunction')->name('isActiveFunction');
Route::resource('employees', 'CRM\EmployeesController');
Route::post('employees/search', ['as' => 'employees/search',  'uses' => 'CRM\EmployeesController@search']);

/* Contacts */
Route::resource('contacts', 'CRM\ContactsController');
Route::post('contacts/search', ['as' => 'contacts/search',  'uses' => 'CRM\ContactsController@search']);

/* Tasks */
Route::get('/tasks/set-active/{id}/{value}', 'CRM\TasksController@isActiveFunction')->name('isActiveFunction');
Route::resource('tasks', 'CRM\TasksController');
Route::post('tasks/search', ['as' => 'tasks/search',  'uses' => 'CRM\TasksController@search']);
Route::get('/tasks/completed/{id}', 'CRM\TasksController@completedTask')->name('completeTask');
Route::get('/tasks/uncompleted/{id}', 'CRM\TasksController@uncompletedTask')->name('uncompletedTask');


/* Files */
Route::get('/files/set-active/{id}/{value}', 'CRM\FilesController@isActiveFunction')->name('isActiveFunction');
Route::resource('files', 'CRM\FilesController');
Route::post('files/search', ['as' => 'files/search',  'uses' => 'CRM\FilesController@search']);

/* Mailing */
Route::post('/mailing/send/{email}', 'CRM\MailingController@sendEmailToThisEmailAddress')->name('sendEmailToThisEmailAddress');
Route::resource('mailing', 'CRM\MailingController');
Route::post('mailing/search', ['as' => 'mailing/search',  'uses' => 'CRM\MailingController@search']);

/* MailManager */
Route::get('mail_manager', 'CRM\MailManagerController@index')->name('mail_manager');

/* Sales */
Route::get('/sales/set-active/{id}/{value}', 'CRM\SalesController@isActiveFunction')->name('isActiveFunction');
Route::resource('sales', 'CRM\SalesController');
Route::post('sales/search', ['as' => 'sales/search',  'uses' => 'CRM\SalesController@search']);

/* Products */
Route::get('/products/set-active/{id}/{value}', 'CRM\ProductsController@isActiveFunction')->name('isActiveFunction');
Route::resource('products', 'CRM\ProductsController');
Route::post('products/search', ['as' => 'products/search',  'uses' => 'CRM\ProductsController@search']);


/* Projects */
Route::get('/projects/set-active/{id}/{value}', 'CRM\ProjectsController@isActiveFunction')->name('isActiveFunction');
Route::resource('projects', 'CRM\ProjectsController');
Route::post('projects/search', ['as' => 'projects/search',  'uses' => 'CRM\ProjectsController@search']);

/* Finances */
Route::get('/finances/set-active/{id}/{value}', 'CRM\FinancesController@isActiveFunction')->name('isActiveFunction');
Route::resource('finances', 'CRM\FinancesController');
Route::post('finances/search', ['as' => 'finances/search',  'uses' => 'CRM\FinancesController@search']);

/* Invoices */
Route::get('/invoices/set-active/{id}/{value}', 'CRM\InvoicesController@isActiveFunction')->name('isActiveFunction');
Route::get('/invoices/download/{id}', 'CRM\InvoicesController@getInvoice')->name('getInvoice');
Route::resource('invoices', 'CRM\InvoicesController');
Route::post('invoices/search', ['as' => 'invoices/search',  'uses' => 'CRM\InvoicesController@search']);


/* Reports */
Route::get('/reports/set-active/{id}/{value}', 'CRM\ReportsController@isActiveFunction')->name('isActiveFunction');
Route::resource('reports', 'CRM\ReportsController');
Route::post('reports/search', ['as' => 'reports/search',  'uses' => 'CRM\ReportsController@search']);

/* Settings */
Route::resource('settings', 'CRM\SettingsController');
Route::get('/settings', 'CRM\SettingsController@index')->name('settings');



Route::get('/', 'DashboardController@index')->name('home');
Route::get('/', 'DashboardController@index');
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

});