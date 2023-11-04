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

use Modules\QR\Http\Controllers\QRController;

Route::prefix('admin/qr')->group(function() {
    Route::get('/', 'QRController@index')->middleware('auth');
    Route::post('/get-qr', [QRController::class, 'getQrCodes'])->name('qr.getQrCodes')->middleware('auth');

    Route::post('/create', 'QRController@store')->middleware('auth');
});
