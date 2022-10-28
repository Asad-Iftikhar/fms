<?php

namespace App\Http\Controllers\User;


use App\Http\Controllers\AuthController;
use App\Models\Fundings\FundingCollection;
use App\Models\Events\Event;
use Illuminate\Support\Facades\Auth;
use DB;

class CollectionController extends AuthController
{
    /**
     * Get Home Page View
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        if (!Auth::check()) {
            return view( 'site.account.login' );
        }
        else {
            $User =  Auth::user();
            $paidCollection = FundingCollection::where('user_id',$User->id)->where('is_received','=',1)->get();
            return view("user.collection",compact('paidCollection'));
        }
    }
}
