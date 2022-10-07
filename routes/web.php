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
Route::get( 'account/setting/remove-avatar', 'Account\AccountController@removeAvatar' );

Route::get( 'account/setting/change-password', 'Account\AccountController@getProfileSettings' );
Route::post( 'account/setting/change-password', 'Account\AccountController@postChangePassword' );


# Login
Route::get( 'account/login', 'AuthController@index' );
Route::post( 'account/login', 'AuthController@postLogin' );

# Forgot Password
Route::get( 'account/forgot-password', 'AuthController@getForgetPassword' );
Route::post( 'account/forgot-password', 'AuthController@postForgotPassword' );

# Reset Password
Route::get( 'account/reset-password/{token}', 'AuthController@getResetPassword' );
Route::post( 'account/reset-password/{token}', 'AuthController@postResetPassword' );

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

#Admin users
Route::get( 'admin/users', 'Admin\Users\AdminUsersController@getIndex' );
Route::get('admin/users/getuser','Admin\Users\AdminUsersController@fetch_user');
Route::get( 'admin/users/add', 'Admin\Users\AdminUsersController@addUser' );
Route::post( 'admin/users/add', 'Admin\Users\AdminUsersController@postUser' );

