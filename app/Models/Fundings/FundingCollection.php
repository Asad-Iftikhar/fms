<?php

namespace App\Models\Fundings;

/**
 * App\Models\Fundings\FundingCollection
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FundingCollection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FundingCollection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FundingCollection query()
 * @mixin \Eloquent
 */

use App\Models\Base;
use App\Models\Events\Event;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Casts\Attribute;

class FundingCollection extends Base {
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'funding_collections';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('user_id', 'funding_type_id', 'amount', 'event_id' ,'is_recieved');

    /**
     * @return mixed
     */
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return mixed
     */
    public function fundingType() {
        return $this->belongsTo(FundingType::class,'funding_type_id');
    }

    /**
     * @return mixed
     */
    public function event() {
        return $this->belongsTo(Event::class,'event_id');
    }

    public function getCollectionTypeName() {
        if (is_null($this->event_id)) {
            return $this->fundingType->name;
        } else {
            return 'Event';
        }
    }

    public function getEventName() {
        if (is_null($this->event_id)) {
            return 'N/A';
        } else {
            return ucfirst($this->event->name);
        }
    }
    public static function totalAvailableFunds() {
        $collections = fundingCollection::where('is_received',1)->sum('amount');
        $spendings = Event::where('status','finished')->sum('event_cost');
        return intval($collections - $spendings);
    }



    public function firstName()
    {
        return $this->user->username;
    }
}
