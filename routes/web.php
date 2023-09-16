<?php

use App\Http\Controllers\CustomerController;
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

// Route::get('/', function () {
//     return view('home');
// });

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Auth::routes();

Route::get('/', [CustomerController::class,'index'])->name('customer.index');

Route::post('/customer/add', [CustomerController::class,'addCustomer'])->name('customer.addCustomer');

Route::get('/{customUrl}',[CustomerController::class,'getCustomer'])->name('customer.getCustomer');


Route::get('/{customUrl}/edit', [CustomerController::class,'editCustomerView'])->name('customer.editCustomerView');

Route::post('/{customUrl}/edit', [CustomerController::class,'editCustomer'])->name('customer.editCustomer');

Route::post('/customer/image', [CustomerController::class,'saveCustomerImage'])->name('customer.saveCustomerImage');

Route::post('/customer/delete', [CustomerController::class,'deleteCustomer'])->name('customer.deleteCustomer');
