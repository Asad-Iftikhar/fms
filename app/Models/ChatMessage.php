<?php

namespace App\Models;

use App\Models\Fundings\FundingCollection;
use App\Models\Media\Media;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Users\User;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'from_user', 'collection_id'];

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
}
