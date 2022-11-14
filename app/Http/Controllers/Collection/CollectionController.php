<?php

namespace App\Http\Controllers\Collection;


use App\Events\PushNotificationEvent;
use App\Http\Controllers\AuthController;
use App\Models\Fundings\FundingCollectionMessage;
use App\Models\Fundings\FundingCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Pusher\Pusher;


class CollectionController extends AuthController
{
    /**
     * Get Home Page View
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        if (!Auth::check()) {
            return view('site.account.login');
        } else {
            $User = Auth::user();
            $receivedCollection = FundingCollection::where('user_id', $User->id)->where('is_received', '=', 1)->get();
            $previousPendingCollection = FundingCollection::where('user_id', $User->id)->where('is_received', '=', 0)->get();
            return view("site.collection.received", compact('receivedCollection', 'previousPendingCollection'));
        }
    }

    /**
     * Previous Collection with respect to id
     *
     * @param $fundingCollectionId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function detail($fundingCollectionId) {
        if ($fundingCollection = FundingCollection::find($fundingCollectionId)) {
            $user = Auth::user();
            if ($fundingCollection->user_id == $user->id) {
                // Mark all received messages as read
                FundingCollectionMessage::markMessagesAsRead($fundingCollectionId, $user->id);
                return view('site.collection.detail', compact('fundingCollection'));
            } else {
                return redirect('collections')->with('error', "Insufficient permission");
            }
        }
        return redirect('collections')->with('error', "No Record Exist");
    }


    /**
     * send messages using pusher -> user side
     *
     * @param $collectionId
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendMessage($collectionId)
    {
        $response = [
            'status' => false,
            'message' => ''
        ];
        if ($fundingCollection = FundingCollection::find($collectionId)) {
            $user = Auth::user();
            if ($user->id == $fundingCollection->user_id) {
                $rules = array(
                    'content' => 'required|string',
                    'collection_id' => 'required|string',
                    'chat_image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
                );
                $validator = Validator::make(request()->only(['content', 'collection_id', 'image_id']), $rules);

                if ($validator->passes()) {
                    $chat = new FundingCollectionMessage();
                    $chat->collection_id = request()->input('collection_id');
                    $chat->from_user = $user->id;
                    $chat->content = request()->input('content');
                    if (request()->hasFile('chat_image')) {
                        $filename = $this->upload_file(request()->file('chat_image'), '/chat/', 'chat_');
                        $chat->image_id = $filename;
                    }
                    if ($chat->save()) {
                        $response['status'] = true;
                        $response['message'] = $chat->getMessageHtml();

                        // Chat message event
                        event(new PushNotificationEvent('my-event-admin', $chat->getSentMessageHtml()));

                    } else {
                        return response()->json($response);
                    }
                }
            }
        }
        return response()->json($response);
    }

    /**
     * Mark unread messages as read
     *
     * @param $fundingCollectionId
     */
    public function markMessageAsRead($fundingCollectionId) {
        if ( $fundingCollection = FundingCollection::with('messages')->find($fundingCollectionId) ) {
            if ($fundingCollection->user_id == auth()->id()) {
                $user = Auth::user();
                FundingCollectionMessage::markMessagesAsRead($fundingCollectionId, $user->id);
            }
        }

    }
}
