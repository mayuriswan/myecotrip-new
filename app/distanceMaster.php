<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class distanceMaster extends Model
{
    protected $table = 'DistanceMaster';     
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "name", "status"
    ];  
}
