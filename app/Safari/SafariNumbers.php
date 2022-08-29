<?php

namespace App\Safari;

use Illuminate\Database\Eloquent\Model;

class SafariNumbers extends Model
{
    /**
     * The mapping between model with table.
     *
     * @var string
     */

    protected $table = 'safariTimeslotsVehicles';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'safari_id','transportation_id','vehicle_id','timeslot_id','isActive'
    ];
}
