<?php

namespace App\JungleStay;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use SoftDeletes;
    protected $table = "js_parking_types";

    protected $fillable = ["id", "type", "shortDesc", "bill_name", "isActive", "created_at", "updated_at"];

    protected $hidden = ["created_at", "updated_at"];

    protected $dates = ['deleted_at'];
}
