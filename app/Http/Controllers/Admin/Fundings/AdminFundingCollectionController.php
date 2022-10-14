<?php

namespace App\Http\Controllers\Admin\Fundings;

use App\Http\Controllers\AdminController;
use App\Models\Events\Event;
use App\Models\Fundings\FundingCollection;
use App\Models\Fundings\FundingType;
use App\Models\Users\User;
use PHPUnit\TextUI\Exception;
use Illuminate\Support\Facades\Validator;

/**
 * Class AdminFundingCollectionController
 */
class AdminFundingCollectionController extends AdminController {

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
        //$availableEvents = Event::all();
        return view('admin.fundingCollections.create',compact('fundingCollections', 'availableUsers', 'availableFundingTypes'));
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
            $selectedFundingType = request()->input('funding_type_id');
            // Create funding collection of each user
            foreach ( $selectedUser as $user ) {
                $fundingCollection = new FundingCollection();
                $fundingCollection->user_id = $user->id;
                $fundingCollection->funding_type_id = $selectedFundingType;
                $fundingCollection->is_received = request()->input('is_received', 0);
                if ( ! $fundingCollection->save() ) {
                    return redirect('admin/funding/collections/create')->with('error', "operation failed");
                }
            }
        } catch (Exception ) {
            return redirect('admin/funding/collections/create')->with('error', "operation failed");
        }
        return redirect('admin/funding/collections/create')->with('success', "Created successfully");
    }

    public function fetchData() {
        $fundCollectionTable = FundingCollection::all();
        $response['data'] = $fundCollectionTable;
        return response()->json($response);
    }
}
