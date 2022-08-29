<?php

namespace App\BirdSanctuary;

use Illuminate\Database\Eloquent\Model;

class boatTypePrice extends Model
{
    /**
     * The mapping between model with table.
     *
     * @var string
     */

    protected $table = 'birdSanctuaryBoatTypePrice';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ["id", "birdSanctuary_id", "boatType_id", "pricing_master_id", "from_date", "to_date", "price", "version", "remarks", "isActive", "created_at", "updated_at"
    ];
}
