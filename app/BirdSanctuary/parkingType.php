<?php

namespace App\BirdSanctuary;

use Illuminate\Database\Eloquent\Model;

class parkingType extends Model
{
    /**
     * The mapping between model with table.
     *
     * @var string
     */

    protected $table = 'birdSanctuaryParkingType';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'birdSanctuary_id','type','isActive'
    ];

    protected $hidden = ['created_at', 'updated_at' ];
}
