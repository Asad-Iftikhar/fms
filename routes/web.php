<?php

use Illuminate\Support\Facades\Route;


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

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
});

Route::get('/admin/change-password', function () {
    return view('auth.change-password');
});
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});
Route::post('/login', [\App\Http\Controllers\LoginController::class , 'login'])->name('login');
Route::get('/logout', [\App\Http\Controllers\LoginController::class , 'logout'])->name('logout');

Route::middleware('auth')->group(function (){
    Route::get('/logout', [\App\Http\Controllers\LoginController::class , 'logout'])->name('logout');
    Route::get('/admin/change-password', function () {
        return view('auth.change-password');
    });
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });
});
