<?php

namespace App\BirdSanctuary;

use Illuminate\Database\Eloquent\Model;

class birdSanctuary extends Model
{
    /**
     * The mapping between model with table.
     *
     * @var string
     */

    protected $table = 'birdSanctuary';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'park_id','name','logo','description','meta_desc','meta_title','keywords','activity','contactinfo','map_url','isActive', 'boat_types','vehicle_types', 'camera_types'
    ];
}
