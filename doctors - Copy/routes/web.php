<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'vishal'])->name('home');
Route::get('admin/home', [HomeController::class, 'adminHome'])->name('admin.home')->middleware('is_admin');

Route::resource('admin', HomeController::class);

Route::get('/accept/{id}',[HomeController::class,'approve'])->name('admin.approve');
Route::get('user_export', [HomeController::class,'export'])->name('user.export');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/adminactive/{id}',[HomeController::class,'active'])->name('admin.active');
Route::get('/admininactive/{id}',[HomeController::class,'inactive'])->name('admin.inactive');



