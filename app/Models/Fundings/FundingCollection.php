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
    protected $fillable = array('amount', 'user_id', 'event_id', 'is_recieved');
    /**
     * @var mixed
     */

    public function users() {
        return $this->belongsTo(User::class, 'user_id')->withTimestamps();
    }

    public function fundingtypes() {
        return $this->belongsTo(FundingType::class,'fund_type_id')->withTimestamps();
    }

    public function events() {
        return $this->belongsTo(Event::class,'event_id')->withTimestamps();
    }

    public static function totalAvailableFunds() {
        $collections = fundingCollection::where('is_received',1)->sum('amount');
        $spendings = Event::where('status','finished')->sum('event_cost');
        return intval($collections - $spendings);
    }




}
