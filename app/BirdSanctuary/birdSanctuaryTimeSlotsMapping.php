<?php

namespace App\BirdSanctuary;

use Illuminate\Database\Eloquent\Model;

class birdSanctuaryTimeSlotsMapping extends Model
{
    /**
     * The mapping between model with table.
     *
     * @var string
     */

    protected $table = 'birdSanctuaryTimeSlotsMapping';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'birdSanctuary_id','boatType_id','timeslots_id','isActive'
    ];
}
