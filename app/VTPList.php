<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VTPList extends Model
{
    protected $table = "vtp_list";
    protected $fillable = ["email", "status"];
}
