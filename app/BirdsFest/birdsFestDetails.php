<?php

namespace App\BirdsFest;

use Illuminate\Database\Eloquent\Model;

class birdsFestDetails extends Model
{
    /**
     * The mapping between model with table.
     *
     * @var string
     */

    protected $table = 'birdsFestDetails';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id','name','logo','s3_upload','description','meta_desc','meta_title','keywords','activity','contactinfo','map_url','isActive'
    ];
}
