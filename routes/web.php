<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;

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

Route::group(['middleware' => ['auth']], function() {
	Route::get('/', [HomeController::class, 'index'])->name('home');
	Route::get('logout', [LoginController::class, 'logout'])->name('logout');
	Route::resource('companies', CompanyController::class);
	Route::resource('employees', EmployeeController::class);
});


Auth::routes([
	'register' => false, 
	'reset' => false, 
	'verify' => false, 
]);
