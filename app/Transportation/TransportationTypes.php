<?php

namespace App\Transportation;

use Illuminate\Database\Eloquent\Model;

class TransportationTypes extends Model
{
    /**
     * The mapping between model with table.
     *
     * @var string
     */

    protected $table = 'transportationTypes';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','isActive'
    ];

}
