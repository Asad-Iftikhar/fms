<?php

namespace App\Models\Fundings;

use App\Models\Fundings\FundingCollection;
use App\Models\Media\Media;
use Illuminate\Database\Eloquent\Model;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class FundingCollectionMessage extends Model
{
    protected $table = 'funding_collection_messages';

    protected $fillable = ['content', 'from_user', 'collection_id'];

    public const PendingCollectionMessages = 0;
    public const ReceivedCollectionMessages = 1;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fundingCollection()
    {
        return $this->belongsTo(FundingCollection::class, 'collection_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function chatMedia()
    {
        return $this->belongsTo(Media::class, 'image_id');
    }

    /**
     * Function which authorize message sent from authorized/logged user
     *
     * @return bool
     */
    public function IsMine() {
        if ( \Auth::user()->id === $this->from_user ) {
            return true;
        }

        return false;
    }

    /**
     *
     * @return html div
     */
    public function getMessageHtml()
    {
        if (is_null($this->image_id)) {
            return '<div class="chat ' . ($this->IsMine() ? '' : 'chat-left') . '"><div class="chat-body"><div class="chat-message" id="user_message">' . $this->content . '<br>' . '<span style="font-size: x-small">'.date('d M y, h:i a', strtotime($this->created_at)).'</span>' .'</div></div></div>';
        }
        // message with thumbnail
        return '<div class="chat ' . ($this->IsMine() ? '' : 'chat-left') . '"><div class="chat-body"><div class="chat-message" id="user_message">' . $this->chatMedia->getImageThumbnail() .'<br>'. $this->content . '<br>' . '<span style="font-size: x-small">'.date('d M y, h:i a', strtotime($this->created_at)).'</span>' .'</div></div></div>';
    }

    /**
     * @return html div
     */
    public function getSentMessageHtml()
    {
        if (is_null($this->image_id)) {
            return '<div class="chat chat-left"><div class="chat-body"><div class="chat-message" id="user_message">' . $this->content . '<br>' . '<span style="font-size: x-small">'.date('d M y, h:i a', strtotime($this->created_at)).'</span>' .'</div></div></div>';
        }
        // message with thumbnail
        return '<div class="chat chat-left"><div class="chat-body"><div class="chat-message" id="user_message">' . $this->chatMedia->getImageThumbnail() .'<br>'. $this->content . '<br>' . '<span style="font-size: x-small">'.date('d M y, h:i a', strtotime($this->created_at)).'</span>' .'</div></div></div>';
    }

    /**
     * @param $collectionId
     * @param $userId
     */
    static public function markMessagesAsRead ($collectionId, $userId) {
        DB::connection()->enableQueryLog();
        FundingCollectionMessage::where('collection_id',$collectionId)->where('from_user', '!=', $userId)->update(['is_read'=>'1']);
    }

    /**
     * Get Unread Messages Count
     *
     * @param integer $userId
     * @param boolean|null $isPending
     * @param integer|null $collectionId
     */
    public static function getUnreadMessagesCountByUserId(int $userId, $isPending = null, $collectionId = null) {

        $UnreadCountQuery =  FundingCollectionMessage::whereHas('fundingCollection', function ($subQuery) use ($userId, $isPending) {
            $subQuery->where('user_id', $userId);
            if (!is_null($isPending)) {
                $subQuery->where('is_received', $isPending);
            }
        })->where('is_read', 0)->where('from_user', '!=', $userId);
        if (!is_null($collectionId)) {
            $UnreadCountQuery->where('collection_id', $collectionId);
        }
        return $UnreadCountQuery->get()->count();

    }

    public static function getUnreadMessagesCountByAdminId($collectionId = null) {
        $UnreadCountQuery = FundingCollectionMessage::where('collection_id',$collectionId)->where('is_read',0)
            ->leftJoin('funding_collections', function ($query) {
               $query->on('funding_collection_messages.collection_id','=','funding_collections.id')
               ->where('funding_collection_messages.from_user','!=','funding_collections.user_id');
            });
        return $UnreadCountQuery->get()->count();
    }
}
