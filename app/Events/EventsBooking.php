<?php

namespace App\Events;

use Illuminate\Database\Eloquent\Model;

class EventsBooking extends Model
{
    protected $table = 'eventsBooking';

    protected $fillable = ["id", "display_id", "user_id", "event_id", "booking_type_id", "date_of_booking", "checkIn", "number_of_tickets", "amount", "amountWithTax", "gst_amount","kedb_amount", "booking_status", "gatewayResponse", "users_details", "booking_source", "created_at", "updated_at", "transaction_id"];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function event()
    {
        return $this->hasOne('App\BirdsFest\birdsFestDetails', 'id', 'event_id');
    }

}
