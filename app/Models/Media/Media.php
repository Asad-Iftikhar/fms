<?php

namespace App\Models\Media;

use App\Models\Base;

/**
 * App\Models\Media\Media
 *
 * @property int $id
 * @property string $name
 * @property string $file_path
 * @property string $url_file
 * @property string $url_thumb
 * @method static \Illuminate\Database\Eloquent\Builder|Media newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Media newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Media query()
 * @mixin \Eloquent
 */
class Media extends Base {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'media';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('name', 'file_path', 'url_file', 'url_thumb');

    public function getImageThumbnail() {
        return '<img src="'. $this->url_file .'" class="figure-img img-fluid rounded">';
    }

}
