<?php

namespace App\JungleStay;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingDetail extends Model
{
    use SoftDeletes;

    protected $table = "js_booking_details";

    protected $fillable = ["id", "ref_no", "booking_id", "room_id", "no_of_rooms","pricing_id", "total_guests", "gst_amount", "total_amount", "guest_details", "entry_details", "booking_status", "created_at", "updated_at", "deleted_at"];

    protected $hidden = ["created_at", "updated_at"];

    protected $dates = ['deleted_at'];

}
