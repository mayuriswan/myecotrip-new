<?php

namespace App\Safari;

use Illuminate\Database\Eloquent\Model;

class SafariBookings extends Model
{
    /**
     * The mapping between model with table.
     *
     * @var string
     */

    protected $table = 'safariBookings';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
            'display_id','safari_id','user_id','transportation_id','date_of_booking','checkIn','no_of_seats','amount','park_entry_amount','service_charge',
            'amount_with_tax','timeslot_id','vehicle_id','booking_status','gateway_response','visitors_details','booking_source','isActive'
    ];
}
