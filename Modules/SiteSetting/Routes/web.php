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

Route::prefix('admin/sitesetting')->group(function() {

    Route::get('/personalinfo', 'SiteSettingController@profileInfoTemp')->middleware('auth');
    Route::get('/contactus', 'SiteSettingController@contactus')->middleware('auth');
    Route::post('/personalinfo/add','SiteSettingController@profileInfoTempAdd')->middleware('auth');
    Route::post('/personalinfo/get','SiteSettingController@getProfileInfoTemp')->name('siteSetting.getPersonalInfo')->middleware('auth');
});


Route::prefix('info/sitesetting')->group(function() {

    Route::get('/personalinfo', 'SiteSettingController@getProfileInfo');

});