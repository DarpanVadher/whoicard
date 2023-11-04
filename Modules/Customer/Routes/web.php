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

use Modules\Customer\Http\Controllers\CustomerController;


Route::group(['prefix' => 'admin'], function () {
    Route::get('/customer', 'CustomerController@adminCutomerList')->middleware('auth');
    Route::post('/getCustomer', [CustomerController::class, 'getCustomersList'])->name('customer.getCustomers')->middleware('auth');
});


Route::group(['prefix' => 'info'], function () {

    Route::get('/', 'CustomerController@index');
    Route::post('/customer/add', 'CustomerController@store');
    Route::get('/{username}','CustomerController@show')->name('customer.view');
    Route::get('/{username}/edit','CustomerController@edit')->name('customer.edit');
    Route::post('/customer/update','CustomerController@update');

});



