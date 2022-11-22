<?php

namespace App\Http\Controllers\Event;


use App\Http\Controllers\AuthController;
use App\Models\Events\Event;
use Illuminate\Support\Facades\Auth;

class EventController extends AuthController
{
    /**
     * Get Home Page View
     * @return \Illuminate\View\View
     */
    public function getIndex() {
        if (!Auth::check()) {
            return view('site.account.login');
        } else {
            $activeEvents = Event::where('status', '=', 'active')->get();
            $finishedEvents = Event::where('status', '=', 'finished')->get();
            return view("site.event.index", compact('activeEvents', 'finishedEvents'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function detail($id, $slug = null) {
        if ($event = Event::find($id)) {
            return view('site.event.detail', compact('event'));
        } else {
            return redirect('events')->with('error', "No Record Exist");
        }
    }
}
