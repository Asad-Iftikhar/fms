<?php

namespace App\Http\Controllers\Admin\Events;

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
        $users = User::where('activated', '1')->get();
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
                        $users=[];
                        foreach( $amounts as $key=>$amount ) {
                            if( $amount > 0 ) {
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
                        if( $event->status == 'active' ) {
                            event(new EventNotification($event));
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
     * @param $event_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getEditEvent ( $event_id ) {
        // Show the page
        $totalFunds = FundingCollection::totalAvailableFunds();
        if($event = Event::with( [ 'getGuests.user', 'fundingCollections.user' ] )->find($event_id)){
            $guestIds = $event->guests()->pluck('user_id')->toArray();
            $selectedUsers = $guestIds;
            $collectionsData = $event->fundingCollections()->get();
            $collections = [];
            if ( $event->status == 'finished' ) {
                $users = User::withTrashed()->get();
            }else{
                $users = User::all();
            }
            foreach ($collectionsData as $element) {
                array_push($selectedUsers, $element->user_id);
                $collections[$element['amount']][] = $element->user_id;
            }
            $selectedUsers = json_encode($selectedUsers);
            $currentDate = \Illuminate\Support\Carbon::now()->toDateString();
            return view('admin.events.edit', compact('event','users', 'guestIds', 'totalFunds', 'collections', 'selectedUsers', 'currentDate'));
        } else {
            return redirect('admin/events')->with( 'error', 'No Event Found !' );
        }
    }

    /**
     * Update Event
     * @param $event_id
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
                // checking weather any collection is paid or not
                if(FundingCollection::where('event_id', $event_id)->where('is_received','1')->first()){
                    $collectionPaid = 1;
                }else{
                    $collectionPaid = 0;
                }
                $event->name = $request->input('name');
                $event->description = $request->input('description');
                $event->event_date = $request->input('event_date');
                if(!($collectionPaid)){
                    // If any collection is paid following attributes will not be updated
                    $event->event_cost = $request->input('event_cost');
                    $event->payment_mode = $request->input('payment_mode');
                    $event->cash_by_funds = $request->input('cash_by_funds');
                }
                $event->status = $request->input('status');
                // Returning errors if some cases are not satisfied in active status
                if ( $event->status == 'active' ) {
                    // Return Error If Funds are insufficent and status is active
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
                                // Return Error If All Collections are not Paid
                                return redirect()->back()->withInput()->with('error', 'All Collections are not marked as paid so you cant save event as finished ');
                            }
                        }
                    } else {
                        // Return Error If All Insufficent Funds are not Paid
                        if( $event->cash_by_funds < $event->event_cost ) {
                            return redirect()->back()->withInput()->with('error', 'Not Enough Funds , Event cant be finished ');
                        }
                    }
                }
                if ($event->save()) {
                    // Save Guests in event_guest table
                    $event->guests()->sync(request()->input('guests', array()));
                    if( $collectionPaid ){
                        // If any collection is paid no need to update further things just return
                        return redirect('admin/events/edit/' . $event->id)->with('success', 'Updated Successfully !, Event Cost , Cash by Funds, Payment Mode and collections cannot be updated because someone has paid collection');
                    }
                    // Delete all old collections
                    fundingCollection::where('event_id',$event->id)->delete();
                    // Save collection
                    if ($event->payment_mode == 2) {
                        if ($amounts = request()->input('amount', array())) {
                            foreach ($amounts as $key => $amount) {
                                if( $amount > 0 ) {
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
        if( $event = Event::find($eventId) ) {
            if( $event->fundingCollections()->where('is_received',1)->first()){
                return redirect()->back()->with('error', "Cannot Delete Because Collection is Paid");
            }
            $event->delete();
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

        $total = Event::count();

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
            $data->payment_mode_name = $data->getPaymentModeName();
            $data->created_by = $data->getUserName();
            $data->statusname = $data->getStatus();
            $data->participants = ($data->fundingCollections->count() + $data->guests()->count() ) ;
            $data->action='<a href="'.url('admin/events/edit').'/'. $data->id .'" class="edit btn btn-sm btn-outline-primary"><i class="iconly-boldEdit"></i></a>&nbsp;<button onClick="confirmDelete(\''.url('admin/events/delete').'/'. $data->id.'\')" class="delete-btn delete btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>';
        }
        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $total,
            "recordsFiltered" => $totalFilter,
            "data" => $arrData,
        );

        return response()->json($response);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function inviteGuest(Request $request) {
        $res = [
            'msg' => 'Something Went Wrong, Please Try Again later',
            'status' => 0
        ];
        $guestId = $request->input('id');
        if ( $guest = EventGuests::find($guestId) ) {
            $guest->is_invited = 1;
            $guest->last_invited = Carbon::now()->toDateTimeString();
            if( $guest->save() ) {
                $guest->email = $guest->user->email;
                $guest->name = $guest->user->getFullName();
                $guest->event_name = $guest->event->name;
                $guest->desc = (empty($guest->event->description) ? 'N/A' : $guest->event->description );
                $guest->date = (empty($guest->event->event_date) ? 'To be Decided' : $guest->event->event_date );
                try {
                    //Email sending
                    Mail::to($guest->email)->send(new InviteGuestMail($guest));
                    $res['invited_text'] = \Carbon\Carbon::createFromTimeStamp(strtotime( $guest->last_invited ))->diffForHumans();
                    $res['btn_text'] = '<i class="iconly-boldSend"></i> Re Invite';
                    $res['msg'] = 'Invited successfully';
                    $res['status'] = 1;
                } catch (\Exception $e) {
                    $res['msg'] = 'Something Went Wrong, Cannot Send Email';
                }
            }
        } else {
            $res['msg'] = 'Guest Not Found';
        }
        return response()->json( $res );
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function inviteParticipant(Request $request) {
        $res = [
            'msg' => 'Something Went Wrong, Please Try Again later',
            'status' => 0
        ];
        $collectionId = $request->input('id');
        if ( $collection = FundingCollection::find($collectionId) ) {
            $collection->is_invited = 1;
            $collection->last_invited = Carbon::now()->toDateTimeString();
            if( $collection->save() ) {
                $collection->email = $collection->user->email;
                $collection->name = $collection->user->getFullName();
                $collection->event_name = $collection->getEvent();
                $collection->desc = (empty($collection->event->description) ? 'N/A' : $collection->event->description );
                $collection->date = (empty($collection->event->event_date) ? 'To be Decided' : $collection->event->event_date );
                try {
                    //Email sending
                    Mail::to($collection->email)->send(new InviteParticipantMail($collection));
                    $res['invited_text'] = \Carbon\Carbon::createFromTimeStamp(strtotime( $collection->last_invited ))->diffForHumans();
                    $res['btn_text'] = '<i class="iconly-boldSend"></i> Re Invite';
                    $res['msg'] = 'Invited successfully';
                    $res['status'] = 1;
                } catch (\Exception $e) {
                    $res['msg'] = 'Something Went Wrong, Cannot Send Email';
                }
            }
        } else {
            $res['msg'] = 'Participant Not Found';
        }
        return response()->json( $res );
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function remindParticipant(Request $request) {
        $res['msg'] = 'Something Went Wrong, Please Try Again later';
        $res['status'] = 0;
        $collectionId = $request->input('id');
        if ( $collection = FundingCollection::find($collectionId) ) {
            if($collection->is_received == 0){
                $collection->is_reminded = 1;
                $collection->last_reminded = Carbon::now()->toDateTimeString();
                if( $collection->save() ) {
                    $collection->email = $collection->user->email;
                    $collection->name = $collection->user->getFullName();
                    $collection->title = $collection->getCollectionTitle();
                    $collection->amount = $collection->amount;
                    try {
                        //Email sending
                        Mail::to($collection->email)->send(new RemindMail($collection));
                        $res['reminded_text'] = \Carbon\Carbon::createFromTimeStamp(strtotime( $collection->last_reminded ))->diffForHumans();
                        $res['btn_text'] = '<i class="iconly-boldSend"></i> Remind again';
                        $res['msg'] = 'Reminder sent successfully';
                        $res['status'] = 1;
                    } catch (\Exception $e) {
                        $res['msg'] = 'Something Went Wrong, Cannot Send Email';
                    }
                }
            } else {
                $res['msg'] = 'Collection is already paid';
            }
        } else {
            $res['msg'] = 'Participant Not Found';
        }
        return response()->json( $res );
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function inviteAll(Request $request) {
        $res = [
            'msg' => 'Something Went Wrong, Please Try Again later',
            'status' => 0
        ];
        $eventId = $request->input('event_id');
        if ( $event = Event::find($eventId) ) {
            if($event->fundingCollections->count() > 0 || $event->getGuests->count() > 0){
                InviteAllParticipants::dispatch($eventId);
                $res['invited_text'] = 'Sending...';
                $res['invite_btn_text'] = '<i class="iconly-boldSend"></i> Re Invite';
                $res['msg'] = 'All participants are invited successfully.';
                $res['status'] = 1;
            }else{
                $res['msg'] = 'No Participants Found';
            }
        } else {
            $res['msg'] = 'Event Not Found';
        }
        return response()->json( $res );
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function remindAll(Request $request) {
        $res = [
            'msg' => 'Something Went Wrong, Please Try Again later',
            'status' => 0
        ];
        $eventId = $request->input('event_id');
        if ( $event = Event::find($eventId) ) {
            if($event->fundingCollections->count() > 0){
                RemindAllParticipants::dispatch($eventId);
                $res['reminded_text'] = 'Sending...';
                $res['remind_btn_text'] = '<i class="iconly-boldSend"></i> Remind again';
                $res['msg'] = 'All participants are reminded successfully';
                $res['status'] = 1;
            }else{
                $res['msg'] = 'No Participants Found';
            }
        } else {
            $res['msg'] = 'Event Not Found';
        }
        return response()->json( $res );
    }
}
