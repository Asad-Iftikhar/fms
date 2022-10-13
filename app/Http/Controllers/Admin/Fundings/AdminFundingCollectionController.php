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

    public function getIndex() {
        # Show Grid of All users
        return view('admin.fundingCollections.index');
    }

    public function getCreateFundingCollection() {
        // Show the page
        $fundingCollections = FundingCollection::all();
        $availableUsers = User::all();
        $availableFundingTypes = FundingType::all();
        return view('admin.fundingCollections.create',compact('fundingCollections', 'availableUsers', 'availableFundingTypes'));
    }

    public function postCreateFundingCollection() {
        $rules = array(
          'users' => 'required|array',
            'type' => 'max:255',
            'description' => 'numeric',
            'is_active' => 'required|in:0,1',
        );
        $validator = Validator::make(request()->only(['users', 'type', 'description', 'is_active']), $rules);
        if ( $validator->fails() ) {
            dd($validator->messages());
            exit;
            return redirect('admin/funding/collections/create')->withInput()->withErrors($validator);
        } else {
            try {
                //$selectedUser = User::WhereIn('id',\request()->input('users'))->get();
                //echo request()->input('funding_type'); exit;
                //$selectedFundtype = FundingType::where('id',\request()->input('funding_type'))->get();
               // $selectedEvent = Event::find('id',\request()->input('events'))->get();
                foreach ( request()->input('users') as $user_id ) {
                    $fundingCollection = new FundingCollection();
                    //$fundingCollection->users($user);
                    $fundingCollection->user_id = $user_id;
                    $fundingCollection->funding_type_id = request()->input('funding_type');
                    //$fundingCollection->fundingtype($selectedFundtype);
                    $fundingCollection->amount = request()->input('description');
                    //$fundingCollection->events($selectedEvent);
                    $fundingCollection->is_received = request()->input('is_active');
                    if ( $fundingCollection->save() ) {
                        dd('saved');
                    }
                }
                dd($selectedUser);

            }
            catch (Exception ) {

            }
        }
    }


    public function getEditFundingCollection() {

    }

    public function postEditFundingCollection() {

    }
}
