<?php

namespace App\Http\Controllers;

use App\Mail\resetpassMail;
use App\Models\Fundings\FundingCollection;
use App\Models\Users\User;
use App\Models\Events\Event;
use Illuminate\Http\Request;
use Illuminate\Mail\SendQueuedMailable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use DB;

class HomeController extends Controller
{
    /**
     * Get Home Page View
     * @return \Illuminate\View\View
     */
    public function getIndex() {
        $totalAmount = FundingCollection::totalAvailableFunds();
        $totalCollection = FundingCollection::getTotalCollection();
        $activeEvents = Event::where('status','=','active')->get();

        // If User Not Login load login view
        if (!Auth::check()) {
            return view( 'site.account.login' );
        }
        $User =  Auth::user();
        $pendingPayment = FundingCollection::getPendingPaymentByUser($User->id);
        $totalSpendings = FundingCollection::getTotalSpendingByUser($User->id);
        $pendingPaymentList = FundingCollection::with('fundingType')->where('user_id',$User->id)->where('is_received','=',0)->leftJoin('events', function ($join){
            $join->on('funding_collections.event_id','=','events.id');
        })->where(function($subQuery) {
            /* @var \Illuminate\Database\Eloquent\Builder $subQuery */
            $subQuery->where('status','!=','draft')->orWhereNull('status');
        })->get();
        return view( 'dashboard', compact( 'pendingPaymentList', 'totalAmount','pendingPayment','totalSpendings', 'totalCollection', 'activeEvents'));
    }
}
