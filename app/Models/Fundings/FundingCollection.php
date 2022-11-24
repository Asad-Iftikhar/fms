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
use App\Models\Fundings\FundingCollectionMessage;
use App\Models\Events\Event;
use App\Models\Notifications\Notification;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Carbon;

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages() {
        return $this->hasMany(FundingCollectionMessage::class,'collection_id')->orderBy('created_at','asc');
    }

    /**
     * Collection Type Name
     * @return string
     */
    public function getCollectionTypeName() {
        if (is_null($this->event_id)) {
            return $this->fundingType->name;
        } else {
            return 'Event';
        }
    }

    /**
     * Collection Type or Event Name
     * @return string
     */
    public function getCollectionTitle() {
        if (is_null($this->event_id)) {
            return $this->fundingType->name;
        } else {
            return $this->event->name;
        }
    }

    /**
     * Event Name as a link
     * @return string
     */
    public function getEventName() {
        if (is_null($this->event_id)) {
            return 'N/A';
        } else {
            return '<a href="'.url("admin/events/edit").'/'. $this->event_id .'" type="button">' . $this->event->name . '</a>';
        }
    }

    /**
     * Total Availabe funds
     * @return int
     */
    public static function totalAvailableFunds() {
        $collections = fundingCollection::where('is_received',1)->sum('amount');
        $spendings = Event::where('status','finished')->sum('event_cost');
        return intval($collections - $spendings);
    }

    /**
     * Payment Status
     * @return string
     */
    public function getPaymentStatusBadge() {
        if ($this->is_received == 1) {
            return '<span class="badge bg-success">Received</span>';
        }
        else {
            return '<span class="badge bg-danger">Pending</span>';
        }
    }

    /**
     * Event name
     * @return string
     */
    public function getEvent() {
        if (is_null($this->event_id)) {
            return 'N/A';
        } else {
            return $this->event->name;
        }
    }

    /**
     * Description
     * @return mixed
     */
    public function getDescription() {
        if (is_null($this->event_id)) {
            return $this->fundingType->description;
        } else {
            return $this->event->description;
        }
    }

    /**
     * Pending Payment by user
     * @param $userId
     * @return int
     */
    public static function getPendingPaymentByUser($userId){
        $pendingPaymentByUser = FundingCollection::with('fundingType')->where('user_id',$userId)->where('is_received','=',0)->leftJoin('events', function ($join){
            $join->on('funding_collections.event_id','=','events.id');
        })->where(function($subQuery) {
            /* @var \Illuminate\Database\Eloquent\Builder $subQuery */
            $subQuery->where('status','!=','draft')->orWhereNull('status');
        })->sum('amount');
        return intval($pendingPaymentByUser);
    }

    /**
     * Total spending by user
     * @param $userId
     * @return int
     */
    public static function getTotalSpendingByUser($userId){
        $totalSpendingByUser = FundingCollection::with('fundingType')->where('user_id',$userId)->where('is_received','=',1)->leftJoin('events', function ($join){
            $join->on('funding_collections.event_id','=','events.id');
        })->where(function($subQuery) {
            /* @var \Illuminate\Database\Eloquent\Builder $subQuery */
            $subQuery->where('status','!=','draft')->orWhereNull('status');
        })->sum('amount');
        return intval($totalSpendingByUser);
    }

    /**
     * Over All pendings on Admin's end
     * @return int
     */
    public static function getOverallPendings(){
        $overallPendings = FundingCollection::with('fundingType')->where('is_received','=',0)->leftJoin('events', function ($join){
            $join->on('funding_collections.event_id','=','events.id');
        })->where(function($subQuery) {
            /* @var \Illuminate\Database\Eloquent\Builder $subQuery */
            $subQuery->where('status','!=','draft')->orWhereNull('status');
        })->sum('amount');
        return intval($overallPendings);
    }

    /**
     * Over All collections on Admin's end
     * @return int
     */
    public static function getTotalCollection() {
        $totalCollection = FundingCollection::with('fundingType')->where('is_received','=',1)->leftJoin('events', function ($join){
            $join->on('funding_collections.event_id','=','events.id');
        })->where(function($subQuery) {
            /* @var \Illuminate\Database\Eloquent\Builder $subQuery */
            $subQuery->where('status','!=','draft')->orWhereNull('status');
        })->sum('amount');
        return intval($totalCollection);
    }

    /**
     * Collection Event Name
     * @return string
     */
    public function getCollectionEventName() {
        if (is_null($this->event_id)) {
            return $this->fundingType->name;
        } else {
            return $this->event->name;
        }
    }

    /**
     * Payment Status
     * @return string
     */
    public function getPaymentStatus() {
        if ($this->is_received == 1) {
            return 'Received';
        }
        else {
            return 'Pending';
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function notifications()
    {
        return $this->morphMany(Notification::class, 'type');
    }
}
