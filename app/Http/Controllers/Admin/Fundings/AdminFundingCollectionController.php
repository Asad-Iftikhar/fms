<?php

namespace App\Http\Controllers\Admin\Fundings;

use App\Http\Controllers\AdminController;
use App\Models\Events\Event;
use App\Models\Fundings\FundingCollection;
use App\Models\Fundings\FundingType;
use App\Models\Users\User;
use Illuminate\Http\Request;
use PHPUnit\TextUI\Exception;
use Illuminate\Support\Facades\Validator;

/**
 * Class AdminFundingCollectionController
 */
class AdminFundingCollectionController extends AdminController {

    /**
     * AdminFundingCollectionController constructor.
     */
    public function __construct() {
        parent::__construct();
        $this->middleware( 'permission:manage_funding_collections' );
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getIndex() {
        # Show Grid of All users
        $fundingCollections = FundingCollection::with('fundingType')->get();
        return view('admin.fundingCollections.index',compact('fundingCollections'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getCreateFundingCollection() {
        // Show the page
        $fundingCollections = FundingCollection::all();
        $availableUsers = User::all();
        $availableFundingTypes = FundingType::all();
        $availableEvents = Event::all();
        return view('admin.fundingCollections.create',compact('fundingCollections', 'availableUsers', 'availableFundingTypes', 'availableEvents'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postCreateFundingCollection() {
        $rules = array(
            'users' => 'required|array',
            'funding_type_id' => 'required|exists:funding_types,id',
            'description' => 'max:255',
            'is_received' => 'required|in:0,1',
        );
        $validator = Validator::make(request()->only(['users', 'funding_type_id', 'description', 'is_received']), $rules);
        if ( $validator->fails() ) {
            return redirect('admin/funding/collections/create')->withInput()->withErrors($validator);
        }
        try {
            $selectedUser = User::WhereIn('id',\request()->input('users'))->get();
            $selectedFundingTypeId = request()->input('funding_type_id');
            $selectedFundingType = FundingType::find($selectedFundingTypeId);
            // Create funding collection of each user
            foreach ( $selectedUser as $user ) {
                $fundingCollection = new FundingCollection();
                $fundingCollection->user_id = $user->id;
                $fundingCollection->funding_type_id = $selectedFundingTypeId;
                $fundingCollection->amount = $selectedFundingType->amount;
                $fundingCollection->is_received = request()->input('is_received', 0);
                if ( ! $fundingCollection->save() ) {
                    return redirect('admin/funding/collections/create')->with('error', "operation failed");
                }
            }
        } catch (Exception ) {
            return redirect('admin/funding/collections/create')->with('error', "operation failed");
        }
        return redirect('admin/funding/collections')->with('success', "Created successfully");
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getEditFundingCollection($id) {
        $fundingtypes = FundingType::all();
        $events = Event::all();
        if ( $fundingCollection = FundingCollection::find($id) ) {
            $selected_fundingtype = $fundingCollection->funding_type_id;
            $selected_event = $fundingCollection->event_id;
            return view('admin.fundingCollections.edit',compact('fundingtypes','fundingCollection','selected_fundingtype','selected_event','events'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postEditFundingCollection($id) {
        if( $fundingCollection = FundingCollection::find($id) ) {
            $rules = array(
                'funding_type_id' => 'required|exists:funding_types,id',
                'is_received' => 'required|in:0,1',
            );

            $validator = Validator::make(request()->only(['funding_type_id', 'is_received']), $rules);
            if ( $validator->fails() ) {
                return redirect('admin/funding/collections/edit/'.$id)->withInput()->withErrors($validator);
            } else {
                try {
                    $fundingCollection->funding_type_id = request()->input('funding_type_id');
                    $fundingCollection->is_received = request()->input('is_received');
                    if ( $fundingCollection->save() ) {
                        return redirect()->back()->with('success', 'Updated Successfully');
                    }
                } catch ( Exception $e ) {
                    return redirect()->back()->with('error', "Something went wrong");
                }
            }
        }
        return redirect()->with('error', "Funding type does not exist");
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchData(Request $request) {


        # Read value
        $draw = $request->get('draw');

        $total = \DB::table('funding_collections')->count();

        $FilterQuery = FundingCollection::with('fundingType');
        if(!empty($searchValue)) {
            $FilterQuery->where('name','like','%'.$searchValue.'%');
        }

        $aColumns = array(
            'id',
            'collectionUserName',
            'collectionTypeName',
            'amount',
            'event_id',
            'is_received',
            'action'
        );

        #Ordering
        if ( request()->has( 'columns' ) ) {
            $Order = request()->input( 'order' );
            $Columns = request()->input( 'columns' );
            \Log::debug($Columns);
            for ( $i = 0, $iMax = count( $Columns ); $i < $iMax; $i++ ) {
                if ( $Columns[$i]['orderable'] == "true" ) {
                    if ( $Order[0]['dir'] === 'asc' ) {
                        $OrderDirection = 'ASC';
                    } else {
                        $OrderDirection = 'DESC';
                    }

                    if ( $Order[0]['column'] == $i ) {
                        $OrderByColumn = $aColumns[$Order[0]['column']];
                        switch ($OrderByColumn) {
                            case 'id' :
                                $FilterQuery->orderBy( 'id', $OrderDirection );
                                break;
                            case 'amount':
                                $FilterQuery->orderBy( 'amount', $OrderDirection );
                                break;
                            case 'collectionUserName' :
                                //Not Sortable
                                break;
                            case 'collectionTypeName':
                            case 'event_id':
                            case 'is_received':
                                //Not Sortable
                                break;
                            case 'actions':
                                //Not Sortable
                                break;
                        }
                    }
                }
            }
        }



        \DB::enableQueryLog(); // Enable query log


        $currentCount = $FilterQuery->count();

        #Paging
        if ( request()->has( 'start' ) && request()->input( 'length' ) != '-1' ) {
            if ( request()->input( 'length' ) < $total ) {
                $FilterQuery->take( request()->input( 'length' ) )->skip( request()->input( 'start' ) );
            }
        }

        $arrData = $FilterQuery->get();

        \Log::debug(\DB::getQueryLog()); // Show results of log


        if(!empty($searchValue)) {
            $arrData = $arrData->where('name','like','%'.$searchValue.'%');
        }

        foreach ($arrData as $collection) {
            $collection->collectionTypeName = $collection->getCollectionTypeName();
            $collection->collectionUserName = $collection->firstName();
        }

        foreach ($arrData as $data){
                $data->action='<a href="'.url('admin/funding/collections/edit').'/'. $data->id .'" class="edit btn btn-outline-info">Edit</a>&nbsp;&nbsp;<button onClick="confirmDelete(\''.url('admin/funding/collections/edit').'/'. $data->id.'\')" class="delete-btn delete btn btn-outline-danger fa fa-trash">Delete</button>';
        }

        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $total,
            "recordsFiltered" => $currentCount,
            "data" => $arrData,
        );
        return response()->json($response);

//        $fundCollectionTable = FundingCollection::all();
//        $response['data'] = $fundCollectionTable;
//        //dd($response);
//        return response()->json($response);
    }
}
