<?php

namespace App\Models\Events;

use App\Models\Base;
use App\Models\Fundings\FundingCollection;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\SoftDeletes;

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
 * @property enum $payment_mode
 * @method static \Illuminate\Database\Eloquent\Builder|Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event query()
 * @mixin \Eloquent
 */
class Event extends Base {

    use SoftDeletes;

    const officeFundOnly = 1;
    const officeFundWithCollection = 2;

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

    /**
     * @var mixed
     */

    public function fundingCollectionEvent() {
        return $this->hasMany(FundingCollection::class,'funding_collections')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function getGuests(): object {
        return $this->hasMany( EventGuests::class, 'event_id' );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function guests(): object {
        return $this->belongsToMany( User::class, 'event_guests', 'event_id', 'user_id' );
    }

    public function user() {
        return $this->belongsTo( User::class, 'created_by' )->withTrashed();
    }

    public function fundingCollections(): object {
        return $this->hasMany( FundingCollection::class, 'event_id' );
    }

    /**
     * User Name
     * @return string
     */
    public function getUserName() {
        return '<a href="'.url("admin/users/edit/".$this->created_by).'" type="button">' . $this->user->username . '</a>';
    }

    /**
     * User Name
     * @return string
     */
    public function getPaymentModeName() {
        if ($this->payment_mode == $this::officeFundWithCollection) {
            return '<span class="badge bg-success">Office Funds With Collections</span>';
        } else {
            return '<span class="badge bg-primary">Office Funds</span>';
        }
    }

    public function getStatus() {
        if($this->status == 'active') {
            return '<span class="badge bg-success">Active</span>';
        }
        elseif ($this->status == 'draft') {
            return '<span class="badge bg-warning">Draft</span>';
        }
        else {
            return '<span class="badge bg-danger">Finished</span>';
        }
    }
}
