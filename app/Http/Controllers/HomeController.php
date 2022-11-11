<?php

namespace App\Http\Controllers;

use App\Events\PushNotificationEvent;
use App\Mail\resetpassMail;
use App\Models\ChatMessage;
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

    /**
     * information of pending payments
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getCollectionInfo($id) {
        $user = Auth::user();
        $rules = [
            'id' => $id
        ];

        $validator = Validator::make($rules, [
            'id' => 'required|exists:funding_collections,id'
        ]);
        if( $validator->passes() ){
            $pending = FundingCollection::find($id);
            if( $pending->user_id == $user->id ) {
                return view('detail',compact('pending'));
            }
            else{
                return redirect('/')->with('error', "Insufficient permission");
            }
        }
        else {
            return redirect('/')->with('error', "No Record Exist");
        }
    }


    /**
     * chat for pending payments
     *
     * @param $collectionId
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendMessage($collectionId){
        $response = [
            'status' => false,
            'message' => ''
        ];
        if ($fundingCollection = FundingCollection::find($collectionId)) {
            $user = Auth::user();
            if($user->id == $fundingCollection->user_id) {
                $rules = array(
                    'content' => 'nullable|string',
                    'collection_id' => 'nullable|string',
                    'chat_image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
                );
                $validator = Validator::make(request()->only(['content','collection_id', 'image_id']),$rules);

                if($validator->passes()) {
                    $chat = new ChatMessage();
                    $chat->collection_id = request()->input('collection_id');
                    $chat->from_user = $user->id;
                    $chat->content = request()->input('content');
                    $chat->is_read = 0;
                    if (request()->hasFile('chat_image')){
                        $filename = $this->upload_file(request()->file('chat_image'),'/chat/','chat_');
                        $chat->image_id = $filename;
                    }
                    if( $chat->save() ) {
                        $response['status'] = true;
                        $response['message'] = $chat->getMessageHtml();

                        // Chat message event
                        event(new PushNotificationEvent('my-event-admin', $chat->getSentMessageHtml()));

                    }
                    else {
                        return response()->json($response);
                    }
                }
            }
        }
        return response()->json($response);
    }
}
