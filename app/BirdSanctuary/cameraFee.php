<?php

namespace App\BirdSanctuary;

use Illuminate\Database\Eloquent\Model;

class cameraFee extends Model
{
    /**
     * The mapping between model with table.
     *
     * @var string
     */

    protected $table = 'birdSanctuaryCameraFee';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "id", "birdSanctuary_id", "cameratype_id", "price", "from_date", "to_date", "version", "isActive", "created_at", "updated_at"
    ];
    
    protected $hidden = ['created_at', 'updated_at' ];
}
