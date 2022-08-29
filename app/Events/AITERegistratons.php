<?php

namespace App\Events;

use Illuminate\Database\Eloquent\Model;

class AITERegistratons extends Model
{
    protected $table = 'AITERegistratons'; 

    protected $fillable = ["name", "email", "contact_no", "VTP_ID", "program_type", "tiger_reserve", "created_at", "updated_at"];    
 	
 	public $timestamps = false;   
}
