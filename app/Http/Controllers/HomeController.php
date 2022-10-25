<?php

namespace App\Http\Controllers;

use App\Mail\resetpassMail;
use App\Models\Fundings\FundingCollection;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Mail\SendQueuedMailable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Get Home Page View
     * @return \Illuminate\View\View
     */
    public function getIndex() {
        $allusers = User::all()->count();
        $total = FundingCollection::totalAvailableFunds();
        // If User Not Login load login view
        if (!Auth::check()) {
            return view( 'site.account.login' );
        }
        // Load Normal User Dashboard (New activities e.g polls ) for now we just show user account dashboard as same as account route
        $User =  Auth::user();
        $collections = FundingCollection::getFundingCollectionsByUserId($User->id);
        return view( 'dashboard', compact( 'collections','allusers', 'total' ));
    }

    public function fetchData(){
       $fcollections = FundingCollection::all();

       foreach ($fcollections as $fcollection){
           if ($fcollection = FundingCollection::where('is_received','=',0)->get()) {
               $fcollection->collectionTypeName = $fcollection->getCollectionTypeName();
               $fcollection->collectiondescription = $fcollection->getdescription();
           }
           return response()->json([
               'data'=>$fcollection,
           ]);
       }
    }
}
