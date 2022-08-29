<?php

namespace App\JungleStay;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    protected $table = "js_bookings";

    protected $fillable = ["id", "display_id", "user_id", "js_id", "date_of_booking", "check_in", "check_out", "total_guests",
                            "total_vehicles", "entry_amount", "stay_amount", "parking_amount", "parking_gst", "transactional_amount",
                            "total_amount", "booking_status","gateway_response", "tracking_id", "bank_ref_no", "vehicle_details", "booking_source", "has_safari", 
                            "created_at", "updated_at", "deleted_at"];

    protected $hidden = ["created_at", "updated_at"];

    protected $dates = ['deleted_at'];
}
