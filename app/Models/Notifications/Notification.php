<?php

namespace App\Models\Notifications;

use App\Models\Base;
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
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }


}
