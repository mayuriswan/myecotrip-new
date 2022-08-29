<?php

namespace App\BirdsFest;

use Illuminate\Database\Eloquent\Model;

class birdFestPricings extends Model
{
    protected $fillable = ["id", "event_id", "name", "per_head_price", "no_of_slots", "remaining_slots", "status", "created_at", "updated_at"];

    protected $table = 'birdsFestPricing';
}
