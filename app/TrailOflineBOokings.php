<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrailOflineBOokings extends Model
{
    protected $fillable = ["id", "name", "contat_no", "email", "display_id", "trail_id", "date_of_booking", "checkIn", "total_trekkers", "number_of_trekkers", "number_of_children", "number_of_students", "amount", "amountWithTax", "gst_amount", "booking_status", "paymentMode", "receipt", "time_slot", "gatewayResponse", "trekkers_details", "booking_source", "created_at", "updated_at"];

    protected $table = "trailOflineBooking";
}
