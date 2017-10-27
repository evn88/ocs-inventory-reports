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
Route::get('/', function(){
    return view('welcome');
});
Route::get('/report', 'ReportsController@allComputers');
Route::get('/report/printers', 'ReportsController@allPrinters');
Route::get('/report/monitors', 'ReportsController@allMonitors');
Route::get('/report/licenses', 'ReportsController@allLicenses');
Route::get('/report/capacity', 'ReportsController@hddCapacity');

Route::get('/report/test', 'ReportsController@test');

Route::get('/api/licenses/{id}', 'LicensesController@getLicenseImage');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
