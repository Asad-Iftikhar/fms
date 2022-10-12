<?php

namespace App\Http\Controllers\Admin\Events;

use App\Http\Controllers\AdminController;
use App\Models\Events\Event;
use App\Models\Users\User;
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
    public function fetchEvents(Request $request) {
        # Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $orderArray = $request->get('order');
        $columnNameArray = $request->get('columns'); //it will give us columns array.

        $searchArray = $request->get('search');
        $columnIndex = $orderArray[0]['column']; //which column index should be sorted.

        $columnName = $columnNameArray[$columnIndex]['data']; //here we will get the column name based on the index we get.

        $columnSortOrder = $orderArray[0]['dir']; //this will get us order direction
        $searchValue = $searchArray['value']; //This is search value

        $event = Event::query()->where('deleted_at', NULL);
        $total = $event->count();

        $totalFilter = Event::query()->where('deleted_at', NULL);
        if (!empty($searchValue)){
            $totalFilter = $totalFilter->where('name', 'like', '%'.$searchValue.'%');
            $totalFilter = $totalFilter->orwhere('status', 'like', '%'.$searchValue.'%');
            $totalFilter = $totalFilter->orwhere('event_cost', 'like', '%'.$searchValue.'%');
            $totalFilter = $totalFilter->orwhere('event_date', 'like', '%'.$searchValue.'%');
        }
        $totalFilter = $totalFilter->count();

        $arrData = Event::query()->where('deleted_at', NULL);
        $arrData = $arrData->skip($start)->take($rowperpage);

        //sorting
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);

        //searching
        if (!empty($searchValue)){
            $arrData = $arrData->where('name', 'like', '%'.$searchValue.'%');
            $arrData = $arrData->orwhere('status', 'like', '%'.$searchValue.'%');
            $arrData = $arrData->orwhere('event_cost', 'like', '%'.$searchValue.'%');
            $arrData = $arrData->orwhere('event_date', 'like', '%'.$searchValue.'%');
        }

        $arrData = $arrData->get();
        foreach ($arrData as $data){
            if( $data->payment_mode==1 ) {
                $data->payment_mode = 'Office Funds';
            }else{
                $data->payment_mode = 'Office Funds & Collections';
            }
            $data->participants = 2;
            $data->action='<a href="'.url('admin/events/edit').'/'. $data->id .'" class="edit btn btn-outline-info">Edit</a>&nbsp;&nbsp;<button onClick="confirmDelete(\''.url('admin/events/delete').'/'. $data->id.'\')" class="delete-btn delete btn btn-outline-danger fa fa-trash">Delete</button>';
        }
        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $total,
            "recordsFiltered" => $totalFilter,
            "data" => $arrData,
        );

        return response()->json($response);
    }

}
