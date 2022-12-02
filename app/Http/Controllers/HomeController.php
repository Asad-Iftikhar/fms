<?php

namespace App\Http\Controllers;

use App\Events\PushNotificationEvent;
use App\Jobs\BirthdayNotification;
use App\Mail\resetpassMail;
use App\Models\Fundings\FundingCollectionMessage;
use App\Models\Fundings\FundingCollection;
use App\Models\Users\User;
use App\Models\Events\Event;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Mail\SendQueuedMailable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use DB;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Get Home Page View
     * listing on the basis of pending payments with respect to specific user
     * @return \Illuminate\View\View
     */
    public function getIndex() {
        // If User Not Login load login view
        if (!Auth::check()) {
            return view( 'site.account.login' );
        }
        $user =  Auth::user();
        $totalAmount = FundingCollection::totalAvailableFunds();
        $totalCollection = FundingCollection::getTotalCollection();
        $activeEvents = Event::where('status','=','active')->get();
        $pendingPayment = FundingCollection::getPendingPaymentByUser($user->id);
        $totalSpendings = FundingCollection::getTotalSpendingByUser($user->id);
        $pendingPaymentList = FundingCollection::select([
            'funding_collections.id as collectionId',
            'funding_collections.*'
        ])->with('fundingType')->where('user_id',$user->id)->where('is_received','=',0)->leftJoin('events', function ($join){
            $join->on('funding_collections.event_id','=','events.id');
        })->where(function($subQuery) {
            /* @var \Illuminate\Database\Eloquent\Builder $subQuery */
            $subQuery->where('status','!=','draft')->orWhereNull('status');
        })->get();
        return view( 'dashboard', compact( 'pendingPaymentList', 'totalAmount','pendingPayment','totalSpendings', 'totalCollection', 'activeEvents'));
    }
}
