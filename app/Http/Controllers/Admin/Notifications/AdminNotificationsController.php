<?php

namespace App\Http\Controllers\Admin\Notifications;

use App\Events\EventNotification;
use App\Http\Controllers\AdminController;
use App\Mail\InviteGuestMail;
use App\Mail\InviteParticipantMail;
use App\Mail\RemindMail;
use App\Models\Events\Event;
use App\Models\Notifications\Notification;
use App\Models\Users\User;
use App\Models\Events\EventGuests;
use App\Models\Fundings\FundingCollection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Mail;
use App\Jobs\InviteAllParticipants;
use App\Jobs\RemindAllParticipants;

class AdminNotificationsController extends AdminController {
    //
    public function __construct() {
        parent::__construct();
        $this->middleware('permission:manage_notifications');
    }

    /**
     * Show a list of events.
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function index() {
        # Show Grid of All Events
        $all_notifications = Notification::getAdminNotifications();
        return view('admin.notifications.index', compact('all_notifications'));
    }


    /**
     * Ajax Request To Get More Admin Notifications
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getAdminNotifications(Request $request)
    {
        $res = [
            'msg' => 'Something Went Wrong, Please Try Again later',
            'status' => 0
        ];
        if (!Auth::check()) {
            $res['msg'] = 'Please Login to Continue';
        } else {
            if($request->input('skip') > 0){
                $skip = $request->input('skip');
                $notifications = Notification::getAdminNotifications($skip);
                if($notifications->count() > 0){
                    foreach ($notifications as $notification) {
                        $notification->icon = $notification->getNotificationIcon();
                        $notification->created_ago = \Carbon\Carbon::createFromTimeStamp(strtotime( $notification->created_at ))->diffForHumans();
                        if( empty($notification->read_at) ) {
                            $notification->read_class = 'bg-light';
                        }else{
                            $notification->read_class = '';
                        }
                    }
                    $res['status'] = 1;
                    $res['notifications'] = $notifications;
                }else{
                    $res['msg'] = 'No More Notifications Found';
                }
            }else{
                $res['msg'] = 'No More Notifications Found';
            }
        }
        return response()->json( $res );
    }


    /**
     * Mark All Notifications of a user as read
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function markAllAdminNotificationsRead(Request $request)
    {
        $res = [
            'msg' => 'Something Went Wrong, Please Try Again later',
            'status' => 0
        ];
        if (!Auth::check()) {
            $res['msg'] = 'Please Login to Continue';
        } else {
            $notifications = Notification::getAllAdminUnreadNotifications();
            if($notifications->count() > 0){
                foreach ($notifications as $notification) {
                    $notification->read_at = \Carbon\Carbon::now()->toDateTimeString();
                    $notification->save();
                }
                $res['status'] = 1;
                $res['msg'] = 'All Notifications are Marked as Read';
            }else{
                $res['msg'] = 'No Unread Notifications Found';
            }
        }
        return response()->json( $res );
    }


    /**
     * Mark Notifications of a user as read
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function markNotificationRead(Request $request)
    {
        $res = [
            'msg' => 'Something Went Wrong, Please Try Again later',
            'status' => 0
        ];
        if (!Auth::check()) {
            $res['msg'] = 'Please Login to Continue';
        } else {
            $notification_id = $request->input('notification_id');
            if($notification_id > 0){
                if($notification = Notification::where('id', $notification_id)->whereNull('read_at')->first()){

                    $notification->read_at = \Carbon\Carbon::now()->toDateTimeString();
                    $notification->save();
                    $res['status'] = 1;
                    $res['msg'] = ' Notifications is Marked as Read';
                }
            }else{
                $res['msg'] = 'No Unread Notification Found';
            }
        }
        $res['unread_count'] = Auth::user()->countUserUnreadNotifications();
        return response()->json( $res );
    }

}
