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
    protected $fillable = array('user_id', 'fund_type_id', 'amount', 'event_id' ,'is_recieved');

    /**
     * @return mixed
     */
    public function users() {
        return $this->belongsTo(User::class, 'user_id')->withTimestamps();
    }

    /**
     * @return mixed
     */
    public function fundingtype() {
        return $this->belongsTo(FundingType::class,'fund_type_id')->withTimestamps();
    }

    /**
     * @return mixed
     */
    public function events() {
        return $this->belongsTo(Event::class,'event_id')->withTimestamps();
    }
}
