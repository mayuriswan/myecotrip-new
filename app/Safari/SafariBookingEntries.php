<?php

namespace App\Safari;

use Illuminate\Database\Eloquent\Model;

class SafariBookingEntries extends Model
{
    /**
     * The mapping between model with table.
     *
     * @var string
     */

    protected $table = 'safariBookingEntries';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'display_id','user_id','safari_id','transportation_id','timeslot_id','checkIn','vehicle_id','amount','no_of_seats','seat_numbers','visitors_details','booking_status'
    ];
}
