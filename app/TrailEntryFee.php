<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrailEntryFee extends Model
{
    protected $table = "trail_entry_fee";

    protected $fillable = ["id", "trail_id", "pricing_master_id", "from_date", "to_date", "price", "version", "remarks", "isActive", "created_at", "updated_at"];
}
