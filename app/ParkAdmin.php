<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParkAdmin extends Model
{
    protected $table = "parkAdmins";

    protected $fillable = [ "name", "park_id", "email", "phone_no", "designation", "password", "status", "created_at", "updated_at" ];
}
