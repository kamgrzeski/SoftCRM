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
Route::get('/client/enable/{id}', 'CRM\ClientController@enable')->name('enable');
Route::get('/client/disable/{id}', 'CRM\ClientController@disable')->name('disable');
Route::resource('client', 'CRM\ClientController');
Route::post('client/search', ['as' => 'client/search',  'uses' => 'CRM\ClientController@search']);

/* Companies */
Route::get('/companies/enable/{id}', 'CRM\CompaniesController@enable')->name('enable');
Route::get('/companies/disable/{id}', 'CRM\CompaniesController@disable')->name('disable');
Route::resource('companies', 'CRM\CompaniesController');
Route::post('companies/search', ['as' => 'companies/search',  'uses' => 'CRM\CompaniesController@search']);

/* Deals */
Route::get('/deals/enable/{id}', 'CRM\DealsController@enable')->name('enable');
Route::get('/deals/disable/{id}', 'CRM\DealsController@disable')->name('disable');
Route::resource('deals', 'CRM\DealsController');
Route::post('deals/search', ['as' => 'deals/search',  'uses' => 'CRM\DealsController@search']);

/* Employees */
Route::get('/employees/enable/{id}', 'CRM\EmployeesController@enable')->name('enable');
Route::get('/employees/disable/{id}', 'CRM\EmployeesController@disable')->name('disable');
Route::resource('employees', 'CRM\EmployeesController');
Route::post('employees/search', ['as' => 'employees/search',  'uses' => 'CRM\EmployeesController@search']);

/* Contacts */
Route::resource('contacts', 'CRM\ContactsController');
Route::post('contacts/search', ['as' => 'contacts/search',  'uses' => 'CRM\ContactsController@search']);

/* Tasks */
Route::get('/tasks/enable/{id}', 'CRM\TasksController@enable')->name('enable');
Route::get('/tasks/disable/{id}', 'CRM\TasksController@disable')->name('disable');
Route::resource('tasks', 'CRM\TasksController');
Route::post('tasks/search', ['as' => 'tasks/search',  'uses' => 'CRM\TasksController@search']);
Route::get('/tasks/completed/{id}', 'CRM\TasksController@completedTask')->name('completeTask');
Route::get('/tasks/uncompleted/{id}', 'CRM\TasksController@uncompletedTask')->name('uncompletedTask');


/* Files */
Route::get('/files/enable/{id}', 'CRM\FilesController@enable')->name('enable');
Route::get('/files/disable/{id}', 'CRM\FilesController@disable')->name('disable');
Route::resource('files', 'CRM\FilesController');
Route::post('files/search', ['as' => 'files/search',  'uses' => 'CRM\FilesController@search']);

/* Mailing */
Route::get('/mailing/enable/{id}', 'CRM\MailingController@enable')->name('enable');
Route::get('/mailing/disable/{id}', 'CRM\MailingController@disable')->name('disable');
Route::post('/mailing/send/{email}', 'CRM\MailingController@sendEmailToThisEmailAddress')->name('sendEmailToThisEmailAddress');
Route::resource('mailing', 'CRM\MailingController');
Route::post('mailing/search', ['as' => 'mailing/search',  'uses' => 'CRM\MailingController@search']);

/* Sales */
Route::get('/sales/enable/{id}', 'CRM\SalesController@enable')->name('enable');
Route::get('/sales/disable/{id}', 'CRM\SalesController@disable')->name('disable');
Route::resource('sales', 'CRM\SalesController');
Route::post('sales/search', ['as' => 'sales/search',  'uses' => 'CRM\SalesController@search']);

/* Products */
Route::get('/products/enable/{id}', 'CRM\ProductsController@enable')->name('enable');
Route::get('/products/disable/{id}', 'CRM\ProductsController@disable')->name('disable');
Route::resource('products', 'CRM\ProductsController');
Route::post('products/search', ['as' => 'products/search',  'uses' => 'CRM\ProductsController@search']);


/* Projects */
Route::get('/projects/enable/{id}', 'CRM\ProjectsController@enable')->name('enable');
Route::get('/projects/disable/{id}', 'CRM\ProjectsController@disable')->name('disable');
Route::resource('projects', 'CRM\ProjectsController');
Route::post('projects/search', ['as' => 'projects/search',  'uses' => 'CRM\ProjectsController@search']);

/* Finances */
Route::get('/finances/enable/{id}', 'CRM\FinancesController@enable')->name('enable');
Route::get('/finances/disable/{id}', 'CRM\FinancesController@disable')->name('disable');
Route::resource('finances', 'CRM\FinancesController');
Route::post('finances/search', ['as' => 'finances/search',  'uses' => 'CRM\FinancesController@search']);

/* Invoices */
Route::get('/invoices/enable/{id}', 'CRM\InvoicesController@enable')->name('enable');
Route::get('/invoices/disable/{id}', 'CRM\InvoicesController@disable')->name('disable');
Route::get('/invoices/download/{id}', 'CRM\InvoicesController@getInvoice')->name('getInvoice');
Route::resource('invoices', 'CRM\InvoicesController');
Route::post('invoices/search', ['as' => 'invoices/search',  'uses' => 'CRM\InvoicesController@search']);


/* Reports */
Route::get('/reports/enable/{id}', 'CRM\ReportsController@enable')->name('enable');
Route::get('/reports/disable/{id}', 'CRM\ReportsController@disable')->name('disable');
Route::resource('reports', 'CRM\ReportsController');
Route::post('reports/search', ['as' => 'reports/search',  'uses' => 'CRM\ReportsController@search']);

/* Settings */
Route::resource('settings', 'CRM\SettingsController');
Route::get('/settings', 'CRM\SettingsController@index')->name('settings');


Route::get('/', 'DashboardController@index')->name('home');
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

});