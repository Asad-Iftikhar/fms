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
Route::get('admin/users/getUsers','Admin\Users\AdminUsersController@fetchUsers');
Route::get( 'admin/users/create', 'Admin\Users\AdminUsersController@getCreateUser' );
Route::post( 'admin/users/create', 'Admin\Users\AdminUsersController@postCreateUser' );
Route::get( 'admin/users/edit/{id}', 'Admin\Users\AdminUsersController@getEditUser' );
Route::post( 'admin/users/edit/{id}', 'Admin\Users\AdminUsersController@postEditUser' );
Route::get( 'admin/users/delete/{id}', 'Admin\Users\AdminUsersController@deleteUser' );

#Admin roles
Route::get( 'admin/roles', 'Admin\Users\AdminRolesController@getIndex' );

#Admin Create roles
Route::get('admin/roles/create', 'Admin\Users\AdminRolesController@getCreateRole');
Route::post('admin/roles/create', 'Admin\Users\AdminRolesController@postCreateRole');

#Admin Update roles
Route::get('admin/roles/edit/{id}', 'Admin\Users\AdminRolesController@getEditRole');
Route::post('admin/roles/edit/{id}', 'Admin\Users\AdminRolesController@postEditRole');
#Delete Role
Route::get('admin/roles/delete/{id}', 'Admin\Users\AdminRolesController@deleteRole');

