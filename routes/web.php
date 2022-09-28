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

Route::get( '/', 'HomeController@getIndex' );

Route::get('/login', function () {
    return view('Auth.login');
});

Route::get('/forgot-password', function () {
    return view('Auth.forgot_password');
});

Route::get('/change-password', function () {
    return view('Auth.change_password');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::post('/login',[\App\Http\Controllers\AuthController::class,'login'])->name('login');
