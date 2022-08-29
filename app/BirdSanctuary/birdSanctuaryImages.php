<?php

namespace App\BirdSanctuary;

use Illuminate\Database\Eloquent\Model;

class birdSanctuaryImages extends Model
{
    protected $table = "birdSanctuaryImages";

    protected $fillable = [ "birdSanctuary_id", "name"];
}
