<?php

namespace App\Models\Events;

use App\Models\Base;
use App\Models\Fundings\FundingCollection;
use App\Models\Users\User;

/**
 * App\Models\Events\Event
 *
 * @property int $id
 * @property string $name
 * @property text $description
 * @property int $created_by
 * @property date $event_date
 * @property int $event_cost
 * @property int $cash_by_funds
 * @property enum $status
 * @method static \Illuminate\Database\Eloquent\Builder|Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event query()
 * @mixin \Eloquent
 */
class Event extends Base {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'events';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('name', 'description', 'created_by', 'event_date', 'event_cost', 'cash_by_funds', 'status', 'payment_mode');
    /**
     * @var mixed
     */

    public function fundingCollectionEvent() {
        return $this->hasMany(FundingCollection::class,'funding_collections')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function guests(): object {
        return $this->belongsToMany( User::class, 'event_guests' )->withTimestamps();
    }

    public function user() {
        return $this->belongsTo( User::class, 'created_by' );
    }

    public function fundingCollections(): object {
        return $this->hasMany( FundingCollection::class, 'event_id' );
    }
}
