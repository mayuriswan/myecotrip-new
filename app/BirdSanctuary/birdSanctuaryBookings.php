<?php

namespace App\BirdSanctuary;

use Illuminate\Database\Eloquent\Model;

class birdSanctuaryBookings extends Model
{
    /**
     * The mapping between model with table.
     *
     * @var string
     */

    protected $table = 'birdSanctuaryBookings';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ["id", "display_id", "ticket_sequence", "birdSanctuary_id", "user_id", "date_of_booking", "checkIn", "booking_info", "device_info", "no_of_entranc_ticket", "no_of_parking_ticket", "no_of_camera_ticket", "no_of_boating_ticket", "entry_charges", "parking_charges", "camera_charges", "boating_charges", "total_charges", "service_charges", "gst_charges", "amount_with_tax", "mode_of_payment", "timeslot", "booking_status", "gateway_response", "booking_source", "created_at", "updated_at"];
}
