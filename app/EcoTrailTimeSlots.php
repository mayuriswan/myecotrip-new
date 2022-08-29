<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EcoTrailTimeSlots extends Model
{
    /**
     * The mapping between model with table.
     *
     * @var string
     */

    protected $table = 'ecotrailTimeSlots';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'timeslots','isActive'
    ];
}
