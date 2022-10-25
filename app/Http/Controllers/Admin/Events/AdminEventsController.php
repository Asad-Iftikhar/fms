<?php

namespace App\Http\Controllers\Admin\Events;

use App\Http\Controllers\AdminController;
use App\Models\Events\Event;
use App\Models\Users\User;
use App\Models\Fundings\FundingCollection;
use eventG;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $totalFunds = FundingCollection::totalAvailableFunds();
        return view('admin.events.create',compact('users','totalFunds'));
    }

    /**
     * Create Event
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postCreateEvent ( Request $request ) {
        //  Validate Form
        if($request->input('status') == 'draft'){
            $rules = array (
                'name' => 'required',
                'description' => 'nullable',
                'event_date' => 'nullable|date',
                'status' => 'required',
                'event_cost' => 'nullable|integer',
                'payment_mode' => 'required',
                'guests' => 'nullable',
                'cash_by_funds' => 'nullable|integer',
                'cash_by_collections' => 'nullable|integer',
            );
        } else {
            $rules = array (
                'name' => 'required',
                'description' => 'nullable',
                'event_date' => 'required|date',
                'status' => 'required',
                'event_cost' => 'required|integer',
                'payment_mode' => 'required',
                'guests' => 'nullable',
                'cash_by_funds' => 'required|integer',
            );
        }
        $validator = Validator::make( request()->all(), $rules );
        if ( $validator->passes() ) {
            $event = new Event;
            $event->name = $request->input('name');
            $event->description = $request->input('description');
            $event->event_date = $request->input('event_date');
            $event->event_cost = $request->input('event_cost');
            $event->status = $request->input('status');
            $event->payment_mode = $request->input('payment_mode');
            $event->cash_by_funds = $request->input('cash_by_funds');
            $event->created_by = Auth::user()->id;
            if ( $event->status == 'active' ) {
                if ( $event->payment_mode == 2 ) {
                    if( ($event->cash_by_funds + $request->input('cash_by_collections'))  != $event->event_cost ) {
                        return redirect()->back()->withInput()->with('error', 'Not Enough Funds , Event Cost should be equal to collections and funds');
                    }
                } else {
                    if( $event->cash_by_funds < $event->event_cost ) {
                        return redirect()->back()->withInput()->with('error', 'Not Enough Funds , Event cant be active ');
                    }
                }
            }
            if ( $event->status == 'finished' ) {
                if ( $event->payment_mode == 2 ) {
                    return redirect()->back()->withInput()->with('error', 'Collections are not marked as paid so you cant save event as finished ');
                } else {
                    if( $event->cash_by_funds < $event->event_cost ) {
                        return redirect()->back()->withInput()->with('error', 'Not Enough Funds , Event cant be finished ');
                    }
                }
            }
            if($event->save()){
                $event->guests()->sync( request()->input( 'guests', array() ) );
                if( $event->payment_mode == 2 ) {
                    if( $amounts = request()->input( 'amount', array() )){
                        foreach( $amounts as $key=>$amount ) {
                            $users = request()->input( 'collection_users' );
                            $users = $users[$key];
                            foreach($users as $user){
                                $fundingCollection = new fundingCollection;
                                $fundingCollection->user_id = $user;
                                $fundingCollection->amount = $amount;
                                $fundingCollection->event_id = $event->id;
                                $fundingCollection->is_received = 0;
                                $fundingCollection->save();
                            }
                        }
                    }
                }
                return redirect( 'admin/events/edit/'.$event->id )->with( 'success', 'Created Successfully !' );
            }else{
                return redirect( 'admin/events/create')->withInput()->with( 'error', 'Something Went Wrong !' );
            }
        }
        // Return with errors
        return redirect( 'admin/events/create' )->withInput()->withErrors( $validator );
    }
    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getEditEvent ( $event_id ) {
        // Show the page
        $users = User::all();
        $totalFunds = FundingCollection::totalAvailableFunds();
        if($event = Event::find($event_id)){
            $guestIds = $event->guests()->pluck('user_id')->toArray();
            $selectedUsers = $guestIds;
            $collectionsData = $event->fundingCollections()->get();
            $result = array();
            foreach ($collectionsData as $element) {
                array_push($selectedUsers, $element->user_id);
                $collections[$element['amount']][] = $element->user_id;
            }
            $selectedUsers = json_encode($selectedUsers);
            return view('admin.events.edit', compact('event','users', 'guestIds', 'totalFunds', 'collections', 'selectedUsers'));
        } else {
            return redirect('admin/events')->with( 'error', 'No Event Found !' );
        }
    }

    /**
     * Update Event
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postEditEvent ( $event_id ) {
        //  Validate Form
        if( $event = Event::find($event_id) ) {
            $request = request();
            if ($request->input('status') == 'draft') {
                $rules = array(
                    'name' => 'required',
                    'description' => 'nullable',
                    'event_date' => 'nullable|date',
                    'status' => 'required',
                    'event_cost' => 'nullable|integer',
                    'payment_mode' => 'required',
                    'guests' => 'nullable',
                    'cash_by_funds' => 'nullable|integer',
                    'cash_by_collections' => 'nullable|integer',
                );
            } else {
                $rules = array(
                    'name' => 'required',
                    'description' => 'nullable',
                    'event_date' => 'required|date',
                    'status' => 'required',
                    'event_cost' => 'required|integer',
                    'payment_mode' => 'required',
                    'guests' => 'nullable',
                    'cash_by_funds' => 'required|integer',
                );
            }
            $validator = Validator::make(request()->all(), $rules);
            if ($validator->passes()) {
                if(FundingCollection::where('event_id', $event_id)->where('is_received','1')->first()){
                    $collectionPaid = 1;
                }else{
                    $collectionPaid = 0;
                }
                $event->name = $request->input('name');
                $event->description = $request->input('description');
                $event->event_date = $request->input('event_date');
                if(!($collectionPaid)){
                    $event->event_cost = $request->input('event_cost');
                    $event->payment_mode = $request->input('payment_mode');
                    $event->cash_by_funds = $request->input('cash_by_funds');
                }
                $event->status = $request->input('status');
//              $event->created_by = Auth::user()->id;
                if ( $event->status == 'active' ) {
                    if ( $event->payment_mode == 2 && $collectionPaid == 0 ) {
                        if( ($event->cash_by_funds + $request->input('cash_by_collections'))  != $event->event_cost ) {
                            return redirect()->back()->withInput()->with('error', 'Not Enough Funds , Event Cost should be equal to collections and funds');
                        }
                    } else {
                        if( $event->cash_by_funds < $event->event_cost && $collectionPaid == 0 ) {
                            return redirect()->back()->withInput()->with('error', 'Not Enough Funds , Event cant be active ');
                        }
                    }
                }
                if ( $event->status == 'finished' ) {
                    if ( $event->payment_mode == 2 ) {
                        foreach( $event->fundingCollections()->get() as $collection ){
                            if ( $collection->is_received == 0 ) {
                                return redirect()->back()->withInput()->with('error', 'All Collections are not marked as paid so you cant save event as finished ');
                            }
                        }
                    } else {
                        if( $event->cash_by_funds < $event->event_cost ) {
                            return redirect()->back()->withInput()->with('error', 'Not Enough Funds , Event cant be finished ');
                        }
                    }
                }
                if ($event->save()) {
                    $event->guests()->sync(request()->input('guests', array()));
                    if( $collectionPaid ){
                        return redirect('admin/events/edit/' . $event->id)->with('success', 'Updated Successfully !, Event Cost , Cash by Funds, Payment Mode and collections cannot be updated because someone has paid collection');
                    }
                    fundingCollection::where('event_id',$event->id)->delete();
                    if ($event->payment_mode == 2) {
                        if ($amounts = request()->input('amount', array())) {
                            foreach ($amounts as $key => $amount) {
                                $users = request()->input('collection_users');
                                $users = $users[$key];
                                foreach ($users as $user) {
                                    $fundingCollection = new fundingCollection;
                                    $fundingCollection->user_id = $user;
                                    $fundingCollection->amount = $amount;
                                    $fundingCollection->event_id = $event->id;
                                    $fundingCollection->is_received = 0;
                                    $fundingCollection->save();
                                }
                            }
                        }
                    }
                    return redirect('admin/events/edit/' . $event->id)->with('success', 'Updated Successfully !');
                } else {
                    return redirect('admin/events/create')->withInput()->with('error', 'Something Went Wrong !');
                }
            }
            // Return with errors
            return redirect('admin/events/create')->withInput()->withErrors($validator);
        }
        return redirect('admin/events');
    }



    /**
     * Soft Delete Event
     * @param $eventId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deleteEvent($eventId) {
        if( fundingCollection::where('event_id',$eventId)->where('is_received',1)){
            return redirect()->back()->with('error', "Cannot Delete Because Collection is Paid");
        }
        if( $event = Event::find($eventId) ) {
            $event->delete();
            $event->guests()->delete();
            $event->fundingCollections()->delete();

            return redirect()->back()->with('success', 'Deleted Successfully');
        } else {
            return redirect()->back()->with('error', "Event doesn't exists");
        }
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
            $data->statusname = $data->getStatus();
            $data->participants = $data->fundingCollections->count() ;
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
