<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class timeMaster extends Model
{
    protected $table = 'TimeMaster';     
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "name", "status"
    ];  
}
