<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrailTimeslot extends Model
{

    use SoftDeletes;

    protected $table = "trail_timeslots";

    protected $fillable = ["id", "trail_id", "pricing_master_id", "timeslot_id", "from_date", "to_date", "price", "version", "remarks", "isActive", "created_at", "updated_at", "deleted_at"];
    
    protected $hidden = ["created_at", "updated_at", "deleted_at"];

    protected $dates = ['deleted_at'];
    
}

