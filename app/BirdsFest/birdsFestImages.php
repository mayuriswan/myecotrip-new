<?php

namespace App\BirdsFest;

use Illuminate\Database\Eloquent\Model;

class birdsFestImages extends Model
{
    protected $table = "birdsFestImages";

    protected $fillable = [ "id", "birdsFest_id", "name", "s3_upload", "created_at", "updated_at",'image_type'];
}
