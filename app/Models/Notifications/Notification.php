<?php

namespace App\Models\Notifications;

use App\Models\Base;
use App\Models\Events\Event;
use App\Models\Fundings\FundingCollection;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Events\Event
 *
 * @property int $id
 * @property int $user_id
 * @property enum $type
 * @property string $title
 * @property text $description
 * @property string $redirect_url
 * @property timestamp $read_at
 * @method static \Illuminate\Database\Eloquent\Builder|Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event query()
 * @mixin \Eloquent
 */
class Notification extends Base {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notifications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('user_id', 'type', 'title', 'description', 'redirect_url', 'read_at');

    /**
     * Get the parent commentable model (post or video).
     */
    public function type()
    {
        return $this->morphTo();
    }


    /**
     * Get Notification Icon
     *
     * @return string
     */
    public function getNotificationIcon() {

        if ($this->type instanceof Event) {
            return '<i class="text-primary iconly-boldActivity"></i>';
        } elseif ( $this->type instanceof FundingCollection ) {
            return '<i class="text-primary bi-cash-stack"></i>';
        } elseif ( $this->type instanceof User ) {
            return '<i class="text-primary iconly-boldUser"></i>';
        } else {
            return '<i class="text-primary iconly-boldActivity"></i>';
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }

    /**
     * Get Admin Latest Unread Notifications
     *
     * @return string
     */
    public static function countAdminUnreadNotifications() {
        return Notification::where('user_type', '=', 'admin')->whereNull('read_at')->count();

    }

    /**
     * Get User Latest Unread Notifications
     *
     * @return string
     */
    public static function getAllAdminUnreadNotifications() {
        return Notification::where('user_type', '=', 'admin')->whereNull('read_at')->get();

    }

    /**
     * Get Admin Latest Unread Notifications
     *
     * @return string
     */
    public static function getAdminLatestUnreadNotifications() {
        $notifications = Notification::where('user_type', '=', 'admin')->whereNull('read_at')->orderBy('created_at', 'DESC')->limit(6)->get();
        foreach ( $notifications as $notification ) {
            if( $notification->type instanceof Event ) {
                $notification->redirect_url = 'admin/event/edit/'.$notification->type->id ;
            } elseif ( $notification->type instanceof FundingCollection ) {
                $notification->redirect_url = 'admin/funding/collections/edit/'.$notification->type->id ;
            } elseif ( $notification->type instanceof User ) {
                $notification->redirect_url = 'admin/users/edit/'.$notification->type->id ;
            } else {
                $notification->redirect_url = '#' ;
            }
        }
        return $notifications;
    }

    /**
     * Get Admin Latest Unread Notifications
     *
     * @return string
     */
    public static function getAdminNotifications( $offset = 0, $limit = 6) {
        $notifications = Notification::where('user_type', '=', 'admin')->orderBy('created_at', 'DESC')->skip($offset)->take($limit)->get();
        foreach ( $notifications as $notification ) {
            if ( $notification->type instanceof Event ) {
                $notification->redirect_url = 'admin/events/edit/'.$notification->type->id ;
            } elseif ( $notification->type instanceof FundingCollection ) {
                $notification->redirect_url = 'admin/funding/collections/edit/'.$notification->type->id ;
            } elseif ( $notification->type instanceof User ) {
                $notification->redirect_url = 'admin/users/edit/'.$notification->type->id ;
            } else {
                $notification->redirect_url = '#' ;
            }
        }
        return $notifications;
    }


}
