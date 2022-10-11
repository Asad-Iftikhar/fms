<?php

namespace App\Models\Events;

use App\Models\Base;

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
    protected $fillable = array('name', 'description', 'created_by', 'event_date', 'event_cost', 'cash_by_funds', 'status');



}
