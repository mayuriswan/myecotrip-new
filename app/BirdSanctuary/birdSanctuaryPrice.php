<?php

namespace App\BirdSanctuary;

use Illuminate\Database\Eloquent\Model;

class birdSanctuaryPrice extends Model
{
    /**
     * The mapping between model with table.
     *
     * @var string
     */

    protected $table = 'birdSanctuaryEntryFee';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ["id", "birdSanctuary_id", "pricing_master_id", "from_date", "to_date", "price", "version", "remarks", "isActive", "created_at", "updated_at"
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
