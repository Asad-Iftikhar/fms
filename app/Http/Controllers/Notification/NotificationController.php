<?php

namespace App\Http\Controllers\Notification;


use App\Http\Controllers\AuthController;
use App\Models\Events\Event;
use App\Models\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NotificationController extends AuthController
{
    /**
     * Get Home Page View
     * @return \Illuminate\View\View
     */
    public function notifications()
    {
        if (!Auth::check()) {
            return view( 'site.account.login' );
        }
        else {
            $user =  Auth::user();
            $all_notifications = $user->getUserNotifications();
            return view("site.notifications.notifications", compact('all_notifications'));
        }
    }

    /**
     * Get User Notifications
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getNotifications(Request $request)
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
                $user =  Auth::user();
                $notifications = $user->getUserNotifications($skip);
                if($notifications->count() > 0){
                    foreach ($notifications as $notification) {
                        $notification->icon = $notification->getNotificationIcon();
                        if( empty($notification->read_at) ) {
                            $notification->read_class = 'bg-light';
                            $notification->created_ago = \Carbon\Carbon::createFromTimeStamp(strtotime( $notification->created_at ))->diffForHumans();
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
    public function markAllRead(Request $request)
    {
        $res = [
            'msg' => 'Something Went Wrong, Please Try Again later',
            'status' => 0
        ];
        if (!Auth::check()) {
            $res['msg'] = 'Please Login to Continue';
        } else {
            $user =  Auth::user();
            $notifications = $user->getAllUserUnreadNotifications();
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
        return response()->json( $res );
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getEvent($id) {

        $rules = [
          'id' => $id
        ];

        $validator = Validator::make($rules, [
           'id' => 'required|exists:events,id'
        ]);

        if($validator->passes())
        {
            if( $event = Event::find($id) ) {
                return view('site.event.detail',compact('event'));
            }
        }
        else {
            return redirect('account/event')->with('error', "No Record Exist");
        }
    }
}
