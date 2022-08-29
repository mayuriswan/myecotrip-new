<?php

namespace App\BirdSanctuary;

use Illuminate\Database\Eloquent\Model;

class boatType extends Model
{
    /**
     * The mapping between model with table.
     *
     * @var string
     */

    protected $table = 'birdSanctuaryBoatType';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'park_id','birdSanctuary_id','name','isActive'
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
