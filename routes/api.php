<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group([
//    'middleware' => 'auth:api'
], function() {
    Route::group(['prefix' => 'admin'], function () {
        Route::post('login', 'AdminController@loginAdmin');
        Route::get('logout', 'AdminController@logoutAdmin');
        Route::get('login/check', 'AdminController@checkLoginAdmin');
        Route::get('profile', 'AdminController@getAdminDetails');
        Route::get('/content', 'CRM\DashboardController@getContent');
    });
});

Route::group(['prefix' => 'admin'], function () {
    Route::post('login', 'AdminController@loginAdmin');
    Route::get('logout', 'AdminController@logoutAdmin');
    Route::get('login/check', 'AdminController@checkLoginAdmin');
    Route::get('profile', 'AdminController@getAdminDetails');
});

Route::group(['prefix' => 'clients'], function () {
    Route::get('/list', 'CRM\ClientsController@processListOfClients');
    Route::get('view/{clientId}', 'CRM\ClientsController@processClientDetails');
    Route::post('store', 'CRM\ClientsController@processCreateClient');
    Route::put('update/{clientId}', 'CRM\ClientsController@processUpdateClient');
    Route::delete('delete/{clientId}', 'CRM\ClientsController@processDeleteClient');
    Route::put('set-active', 'CRM\ClientsController@processSetIsActive');
});

Route::group(['prefix' => 'employees'], function () {
    Route::get('/list', 'CRM\EmployeesController@processListOfEmployees');
    Route::get('view/{employeeId}', 'CRM\EmployeesController@processEmployeeDetails');
    Route::post('store', 'CRM\EmployeesController@processCreateEmployee');
    Route::put('update/{employeeId}', 'CRM\EmployeesController@processUpdateEmployee');
    Route::delete('delete/{employeeId}', 'CRM\EmployeesController@processDeleteEmployee');
    Route::put('set-active', 'CRM\EmployeesController@processSetIsActive');
});

Route::group(['prefix' => 'deals'], function () {
    Route::get('/list', 'CRM\DealsController@processListOfDeals');
    Route::get('view/{dealId}', 'CRM\DealsController@processDealDetails');
    Route::post('store', 'CRM\DealsController@processCreateDeal');
    Route::put('update/{dealId}', 'CRM\DealsController@processUpdateDeal');
    Route::delete('delete/{dealId}', 'CRM\DealsController@processDeleteDeal');
    Route::put('set-active', 'CRM\DealsController@processSetIsActive');
});

Route::group(['prefix' => 'settings'], function () {
    Route::get('/data', 'CRM\SettingsController@processListOfSystemLogs');
    Route::post('store', 'CRM\SettingsController@processStoreSettings');
});
