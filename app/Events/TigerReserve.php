<?php

namespace App\Events;

use Illuminate\Database\Eloquent\Model;

class TigerReserve extends Model
{
    //
    protected $table = 'tigerReserves'; 

    protected $filable = ["name", "status", "slots", "remaningSlots"];    
 	public $timestamps = false;   
    
}
