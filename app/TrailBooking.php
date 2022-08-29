<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrailBooking extends Model
{
    protected $table = "trailBooking";

    protected $fillable = ["id", "display_id", "sequence_no", "user_id", "agent_id", "trail_id", "date_of_booking", "checkIn", "total_trekkers", "number_of_trekkers", "number_of_children", "number_of_students", "time_slot", "amount", "amountWithTax", "gst_amount", "booking_status", "gatewayResponse", "trekkers_details", "booking_source", "device_info", "payment_gateway", "transaction_id", "created_at", "updated_at"];
}
