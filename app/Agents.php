<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agents extends Model
{
    protected $fillable = [ "name", "email", "phone_no", "password", "status", "created_at", "updated_at"];

    protected $table = 'agents';
}
