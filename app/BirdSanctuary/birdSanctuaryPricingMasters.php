<?php

namespace App\BirdSanctuary;

use Illuminate\Database\Eloquent\Model;

class birdSanctuaryPricingMasters extends Model
{
    protected $table = "birdSanctuaryPricingMasters";

    protected $hidden = ['created_at', "updated_at"];
}
