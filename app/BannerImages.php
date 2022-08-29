<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BannerImages extends Model
{
    /**
     * The mapping between model with table.
     *
     * @var string
     */

    protected $table = 'bannerImages';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type','path','href','title', 'short_description', 'button_name',"title_color"
    ];
}
