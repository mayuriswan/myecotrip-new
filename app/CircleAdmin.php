<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CircleAdmin extends Model
{
    protected $table="circleAdmins";

    protected $fillable = ["name", "circle_id", "email", "phone_no", "designation", "password", "status", "created_at", "updated_at" ];
}
