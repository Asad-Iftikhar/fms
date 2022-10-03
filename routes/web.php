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

# Dashboard
Route::get( '/', 'HomeController@getIndex' );
Route::get( 'account', 'Account\AccountController@getIndex' );
# settings
Route::get( 'account/setting/profile', 'Account\AccountController@getProfileSettings' );
Route::post( 'account/setting/profile', 'Account\AccountController@postProfileSettings' );

Route::get( 'account/setting/avatar', 'Account\AccountController@getProfileSettings' );
Route::post( 'account/setting/avatar', 'Account\AccountController@postChangeAvatar' );

Route::get( 'account/setting/change-password', 'Account\AccountController@getProfileSettings' );
Route::post( 'account/setting/change-password', 'Account\AccountController@postChangePassword' );


# Login
Route::get( 'account/login', 'AuthController@index' );
Route::post( 'account/login', 'AuthController@postLogin' );

# Forgot Password
Route::get( 'account/forgot-password', 'AuthController@getForgotPassword' );
Route::post( 'account/forgot-password', 'AuthController@postForgotPassword' );

# Reset Password
Route::get( 'account/reset-password', 'AuthController@getResetPassword' );
Route::post( 'account/reset-password', 'AuthController@postResetPassword' );

# Logout
Route::get( 'account/logout', 'AuthController@getLogout' );

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
|
|
*/
# Admin Dashboard
Route::get( 'admin', 'Admin\AdminDashboardController@getIndex' );
