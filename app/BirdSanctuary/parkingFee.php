<?php

namespace App\BirdSanctuary;

use Illuminate\Database\Eloquent\Model;

class parkingFee extends Model
{
    /**
     * The mapping between model with table.
     *
     * @var string
     */

    protected $table = 'birdSanctuaryParkingFee';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "id", "birdSanctuary_id", "parkingtype_id", "vehicletype_id", "price", "version", "isActive", "created_at", "updated_at", "from_date", "to_date"
    ];

    protected $hidden = ['created_at', 'updated_at' ];
}
