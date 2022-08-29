<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgentBooking extends Model
{
    protected $table = 'agentBooking';

    protected $fillable = ["display_id", "user_id", "trail_id", "date_of_booking", "checkIn", "number_of_trekkers", "amount", "amountWithTax", "booking_status", "gatewayResponse", "trekkers_details", "booking_source", "created_at", "updated_at"];
}
