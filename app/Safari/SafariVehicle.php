<?php

namespace App\Safari;

use Illuminate\Database\Eloquent\Model;

class SafariVehicle extends Model
{
    /**
     * The mapping between model with table.
     *
     * @var string
     */

    protected $table = 'safariVehicleDetails';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'safari_id','transportation_id','vehicle_no','description','displayName','onlineBooking','full_booking','isActive'
    ];
}
