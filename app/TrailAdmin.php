<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrailAdmin extends Model
{
    protected $table = "trailAdmins";

    protected $fillable = [ "name", "trail_id", "email", "phone_no", "designation", "password", "status", "created_at", "updated_at" ];
}
