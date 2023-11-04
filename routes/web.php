<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');




Route::group(['prefix' => 'admin'], function () {
    Auth::routes();

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');


});



Route::get('/info/storage/storage-link', function (){

    $targetFolder = storage_path('app/public');
    $linkFolder = $_SERVER['DOCUMENT_ROOT'].'/public/storage';

    print($linkFolder);
    print($targetFolder);


    symlink($targetFolder, $linkFolder);
});
