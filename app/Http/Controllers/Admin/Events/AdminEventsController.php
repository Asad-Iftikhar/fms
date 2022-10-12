<?php

namespace App\Http\Controllers\Admin\Events;

use App\Http\Controllers\AdminController;
use App\Models\Events\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminEventsController extends AdminController {
    //
    public function __construct() {
        parent::__construct();
        $this->middleware('permission:manage_events');
    }

    /**
     * Show a list of events.
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function getIndex() {
        # Show Grid of All Events
        $events = Event::all();
        return view('admin.events.index', compact('events'));
    }


    /**
     * @return string
     */
    public function getCreateEvent () {
        $users = User::all();
        return view('admin.events.create',compact('users'));
    }

    /**
     * Create Event
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postCreateEvent ( Request $request ) {

    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getEditEvent ( $id ) {

    }

    /**
     * Update Event
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postEditEvent ( $id ) {

    }


    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function fetchEvents ( Request $request ) {

    }

}
