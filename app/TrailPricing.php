<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrailPricing extends Model
{
    protected $table = "trailPricing";

    protected $fillable = [ "trail_id", "ecotrailTimeSlots_id", "from", "to", "price", "status", "created_at", "updated_at"];

}
