<?php

namespace App\Http\Controllers\Admin\Fundings;

use App\Http\Controllers\AdminController;
use App\Models\Events\Event;
use App\Models\Fundings\FundingCollection;
use App\Models\Fundings\FundingType;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use PHPUnit\TextUI\Exception;
use Illuminate\Support\Facades\Validator;

/**
 * Class AdminFundingCollectionController
 */
class AdminFundingCollectionController extends AdminController
{

    /**
     * AdminFundingCollectionController constructor.
     */
    public function __construct() {
        parent::__construct();
        $this->middleware('permission:manage_funding_collections');
    }

    /**
     * Funding Collection Grid
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getIndex() {
        # Show Grid of All funding collection
        $fundingCollections = FundingCollection::with('fundingType')->get();
        return view('admin.fundingCollections.index', compact('fundingCollections'));
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
        return view('admin.fundingCollections.create', compact('fundingCollections', 'availableUsers', 'availableFundingTypes', 'availableEvents'));
    }

    /**
     * Creating Funding Collection
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
        if ($validator->fails()) {
            return redirect('admin/funding/collections/create')->withInput()->withErrors($validator);
        }
        try {
            $selectedUser = User::WhereIn('id', \request()->input('users'))->get();
            $selectedFundingTypeId = request()->input('funding_type_id');
            $selectedFundingType = FundingType::find($selectedFundingTypeId);
            // Create funding collection of each user
            foreach ($selectedUser as $user) {
                $fundingCollection = new FundingCollection();
                $fundingCollection->user_id = $user->id;
                $fundingCollection->funding_type_id = $selectedFundingTypeId;
                $fundingCollection->amount = $selectedFundingType->amount;
                $fundingCollection->is_received = request()->input('is_received', 0);
                if (!$fundingCollection->save()) {
                    return redirect('admin/funding/collections/create')->with('error', "operation failed");
                }
            }
        } catch (Exception) {
            return redirect('admin/funding/collections/create')->with('error', "operation failed");
        }
        return redirect('admin/funding/collections')->with('success', "Created successfully");
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getEditFundingCollection($id) {
        $fundingTypes = FundingType::all();
        $events = Event::all();
        if ($fundingCollection = FundingCollection::find($id)) {
            return view('admin.fundingCollections.edit', compact('fundingTypes', 'fundingCollection', 'events'));
        }
    }

    /**
     * Edit Funding Collection
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postEditFundingCollection($id) {
        if ($fundingCollection = FundingCollection::find($id)) {

            $rules = array(
                'is_received' => 'required|in:0,1',
                'amount' => 'required|numeric'
            );

            if (!empty($fundingCollection->funding_type_id)) {
                $rules['funding_type_id'] = 'required|exists:funding_types,id';
            }

            $validator = Validator::make(request()->all(), $rules);
            if ($validator->fails()) {
                return redirect('admin/funding/collections/edit/' . $id)->withInput()->withErrors($validator);
            } else {
                try {
                    $fundingCollection->is_received = request()->input('is_received');
                    $fundingCollection->funding_type_id = request()->input('funding_type_id');
                    $fundingCollection->amount = request()->input('amount');
                    if ($fundingCollection->save()) {
                        return redirect()->back()->with('success', 'Updated Successfully');
                    }
                } catch (Exception $e) {
                    return redirect()->back()->with('error', "Something went wrong");
                }
            }
        }
        return redirect()->with('error', "Funding type does not exist");
    }

    /**
     * listing data
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchData(Request $request) {
        # Read value
        $draw = $request->get('draw');

        $total = \DB::table('funding_collections')->count();

        $FilterQuery = FundingCollection::with('fundingType');
        $FilterQuery->whereNull('event_id')->orWhereHas( 'event', function($subQuery)
        {
            $subQuery->where('status', '!=', 'draft');
        });
        if (!empty($searchValue)) {
            $FilterQuery->where('name', 'like', '%' . $searchValue . '%');
        }

        # Available columns
        $aColumns = array(
            'id',
            'collectionUserName',
            'collectionTypeName',
            'amount',
            'eventName',
            'is_received',
            'action'
        );

        #Ordering
        if (request()->has('columns')) {
            $Order = request()->input('order');
            $Columns = request()->input('columns');
            for ($i = 0, $iMax = count($Columns); $i < $iMax; $i++) {
                if ($Columns[$i]['orderable'] == "true") {
                    if ($Order[0]['dir'] === 'asc') {
                        $OrderDirection = 'ASC';
                    } else {
                        $OrderDirection = 'DESC';
                    }

                    if ($Order[0]['column'] == $i) {
                        $OrderByColumn = $aColumns[$Order[0]['column']];
                        switch ($OrderByColumn) {
                            case 'id' :
                                $FilterQuery->orderBy('id', $OrderDirection);
                                break;
                            case 'amount':
                                $FilterQuery->orderBy('amount', $OrderDirection);
                                break;
                            case 'collectionUserName' :
                                //Not Sortable
                                break;
                            case 'collectionTypeName':
                            case 'eventName':
                            case 'is_received':
                                $FilterQuery->orderBy('is_received', $OrderDirection);
                                break;
                            case 'actions':
                                //Not Sortable
                                break;
                        }
                    }
                }
            }
        }

        # Searching
        $searchValue = request()->input('search');
        if (!empty($searchValue)) {
            // Searching
        }

        # Count Filtered Data
        $currentCount = $FilterQuery->count();

        #Paging
        if (request()->has('start') && request()->input('length') != '-1') {
            if (request()->input('length') < $total) {
                $FilterQuery->take(request()->input('length'))->skip(request()->input('start'));
            }
        }

        # Get Data
        $arrData = $FilterQuery->get();

        foreach ($arrData as $collection) {
            $collection->collectionTypeName = $collection->getCollectionTypeName();
            $collection->collectionUserName = $collection->firstName();
            $collection->eventName = $collection->getEventName();
            $collection->paymentStatus = $collection->getPaymentStatus();
            $collection->action = '<a href="' . url('admin/funding/collections/edit') . '/' . $collection->id . '" class="edit btn btn-outline-info">Edit</a>&nbsp;&nbsp;<button onClick="confirmDelete(\'' . url('admin/funding/collections/delete') . '/' . $collection->id . '\')" class="delete-btn delete btn btn-outline-danger fa fa-trash">Delete</button>';
        }

        # response
        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $total,
            "recordsFiltered" => $currentCount,
            "data" => $arrData,
        );
        return response()->json($response);

    }

    /**
     * Delete Funding Collection
     * @param $fundingcollectionId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteFundingCollection($fundingcollectionId) {
        $fundingcollection = FundingCollection::find($fundingcollectionId);
        if ( $fundingcollection != null ) {
            if( $fundingcollection->event_id != null ) {
                if( $fundingcollection->is_received == 1 ) {
                    return redirect()->back()->with('error', "Cannot delete");
                }
            }
            else {
                $fundingcollection->delete();
                return redirect()->back()->with('success', 'Deleted Successfully');
            }
        }
    }
}
