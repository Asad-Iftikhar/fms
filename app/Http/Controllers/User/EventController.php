<?php

namespace App\Http\Controllers\User;


use App\Http\Controllers\AuthController;
use App\Models\Fundings\FundingCollection;
use App\Models\Events\Event;
use Illuminate\Support\Facades\Auth;
use DB;

class EventController extends AuthController
{
    /**
     * Get Home Page View
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        if (!Auth::check()) {
            return view( 'site.account.login' );
        }
        else {
            $User =  Auth::user();
            $activeEvents = Event::where('status','=','active')->get();
            $finishedEvents = Event::where('status','=','finished')->get();
            return view("user.event",compact('activeEvents','finishedEvents'));
        }
    }

    public function getEventId($id) {
        if( $event = Event::find($id) ) {
            return view('user.event_view',compact('event'));
        }
    }
}
