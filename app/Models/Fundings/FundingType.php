<?php

namespace App\Models\Fundings;

/**
 * App\Models\Fundings\FundingType
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FundingType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FundingType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FundingType query()
 * @mixin \Eloquent
 */

use App\Models\Base;

class FundingType extends Base {
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'funding_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('name', 'description', 'amount');

}
