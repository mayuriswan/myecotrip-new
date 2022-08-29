<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MyAdmins extends Model
{
    protected $fillable = [ "name", "email", "phone_no", "designation", "password", "status"];
    protected $table = "myAdmins";
}
