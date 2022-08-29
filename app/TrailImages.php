<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrailImages extends Model
{
    protected $table = "trailImages";

    protected $fillable = [ "trail_id", "name", "status", 's3_upload'];

}
