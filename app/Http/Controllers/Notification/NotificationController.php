<?php

namespace App\Http\Controllers\Notification;


use App\Http\Controllers\AuthController;
use App\Models\Events\Event;
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
            $User =  Auth::user();
            return view("site.notifications.notifications");
        }
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
