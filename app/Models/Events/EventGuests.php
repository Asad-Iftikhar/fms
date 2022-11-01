<?php

namespace App\Models\Events;

use App\Models\Base;
use App\Models\Users\User;

/**
 * App\Models\Events\Event
 *
 * @property int $id
 * @property int $event_id
 * @property int $user_id
 * @property boolean $is_invited
 * @mixin \Eloquent
 */
class EventGuests extends Base {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'event_guests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('event_id', 'user_id', 'is_invited', 'last_invited');
    /**
     * @var mixed
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event(): object {
        return $this->BelongsTo( Event::class, 'event_id' );
    }

}
