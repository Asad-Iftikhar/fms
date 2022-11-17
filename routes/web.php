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
Route::get( 'collection/{id}', 'HomeController@getCollectionInfo' );
Route::get( 'account', 'Account\AccountController@getIndex' );

#User Side Collection Route
Route::get('collections','Collection\CollectionController@getIndex');
Route::get('collections/{id}','Collection\CollectionController@detail');
Route::post('collections/{id}/sendMessage','Collection\CollectionController@sendMessage');
Route::get('collections/{id}/markMessagesAsSeen','Collection\CollectionController@markMessageAsRead');

#User Side Event Route
Route::get('events','Event\EventController@getIndex');
Route::get('event/{id}/{name}','Event\EventController@detail');

# settings
Route::get( 'account/setting/profile', 'Account\AccountController@getProfileSettings' );
Route::post( 'account/setting/profile', 'Account\AccountController@postProfileSettings' );

Route::get( 'account/setting/avatar', 'Account\AccountController@getProfileSettings' );
Route::post( 'account/setting/avatar', 'Account\AccountController@postChangeAvatar' );
Route::get( 'account/setting/remove-avatar', 'Account\AccountController@removeAvatar' );

Route::get( 'account/setting/change-password', 'Account\AccountController@getProfileSettings' );
Route::post( 'account/setting/change-password', 'Account\AccountController@postChangePassword' );

# Notifications
Route::get( '/notifications', 'Notification\NotificationController@notifications' );
Route::post( 'get-notifications', 'Notification\NotificationController@getNotifications' );

# Mark Notifications as Read
Route::post( 'mark-all-notifications-read', 'Notification\NotificationController@markAllRead' );
Route::post( 'mark-notification-read', 'Notification\NotificationController@markNotificationRead' );


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

#Admin Create User
Route::get( 'admin/users/create', 'Admin\Users\AdminUsersController@getCreateUser' );
Route::post( 'admin/users/create', 'Admin\Users\AdminUsersController@postCreateUser' );

#Admin Edit User
Route::get( 'admin/users/edit/{id}', 'Admin\Users\AdminUsersController@getEditUser' );
Route::post( 'admin/users/edit/{id}', 'Admin\Users\AdminUsersController@postEditUser' );

#Admin Delete User
Route::get( 'admin/users/delete/{id}', 'Admin\Users\AdminUsersController@deleteUser' );

#Admin Activate/Deactivate User
Route::get( 'admin/users/change-status/{id}', 'Admin\Users\AdminUsersController@changeStatus' );

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

#Admin Funding Types
Route::get( 'admin/funding/types', 'Admin\Fundings\AdminFundingTypeController@getIndex' );

#Admin Create Funding Types
Route::get('admin/funding/types/create', 'Admin\Fundings\AdminFundingTypeController@getCreateFundingType');
Route::post('admin/funding/types/create', 'Admin\Fundings\AdminFundingTypeController@postCreateFundingType');

#Admin Update Funding Types
Route::get('admin/funding/types/edit/{id}', 'Admin\Fundings\AdminFundingTypeController@getEditFundingType');
Route::post('admin/funding/types/edit/{id}', 'Admin\Fundings\AdminFundingTypeController@postEditFundingType');

#Admin Delete Funding Types
Route::get('admin/funding/types/delete/{id}','Admin\Fundings\AdminFundingTypeController@deleteFundingtypes');

#Admin Funding Collection
Route::get('admin/funding/collections','Admin\Fundings\AdminFundingCollectionController@getIndex');
Route::get('admin/funding/collection/getcollections','Admin\Fundings\AdminFundingCollectionController@fetchData');

#Admin Create Funding Collection
Route::get('admin/funding/collections/create','Admin\Fundings\AdminFundingCollectionController@getCreateFundingCollection');
Route::post('admin/funding/collections/create','Admin\Fundings\AdminFundingCollectionController@postCreateFundingCollection');

#Admin Update Funding Collection
Route::get('admin/funding/collections/edit/{id}', 'Admin\Fundings\AdminFundingCollectionController@getEditFundingCollection');
Route::post('admin/funding/collections/edit/{id}', 'Admin\Fundings\AdminFundingCollectionController@postEditFundingCollection');

#Admin Delete Funding collection
Route::get('admin/funding/collections/delete/{id}','Admin\Fundings\AdminFundingCollectionController@deleteFundingCollection');

#Admin Events
Route::get( 'admin/events', 'Admin\Events\AdminEventsController@getIndex' );
Route::get('admin/events/getEvents','Admin\Events\AdminEventsController@fetchEvents');

#Admin Create Events
Route::get( 'admin/events/create', 'Admin\Events\AdminEventsController@getCreateEvent' );
Route::post( 'admin/events/create', 'Admin\Events\AdminEventsController@postCreateEvent' );

#Admin Update Event
Route::get( 'admin/events/edit/{id}', 'Admin\Events\AdminEventsController@getEditEvent' );
Route::post( 'admin/events/edit/{id}', 'Admin\Events\AdminEventsController@postEditEvent' );

#Admin Delete Event
Route::get( 'admin/events/delete/{id}', 'Admin\Events\AdminEventsController@deleteEvent' );

#Admin Ajax Requests to Invite / Remind Event Participants
Route::post( 'admin/events/invite-guest', 'Admin\Events\AdminEventsController@inviteGuest' );
Route::post( 'admin/events/invite-participant', 'Admin\Events\AdminEventsController@inviteParticipant' );
Route::post( 'admin/events/remind-participant', 'Admin\Events\AdminEventsController@remindParticipant' );

#Admin Ajax Requests to Invite / Remind all Event Participants
Route::post( 'admin/events/invite-all', 'Admin\Events\AdminEventsController@inviteAll' );
Route::post( 'admin/events/remind-all', 'Admin\Events\AdminEventsController@remindAll' );

#Admin Notifications
Route::get( 'admin/notifications', 'Admin\Notifications\AdminNotificationsController@index' );
Route::post( 'admin/get-more-admin-notifications', 'Admin\Notifications\AdminNotificationsController@getAdminNotifications' );

# Mark Admin Notifications as Read
Route::post( 'admin/mark-all-admin-notifications-read', 'Admin\Notifications\AdminNotificationsController@markAllAdminNotificationsRead' );
Route::post( 'admin/mark-notification-read', 'Admin\Notifications\AdminNotificationsController@markNotificationRead' );



