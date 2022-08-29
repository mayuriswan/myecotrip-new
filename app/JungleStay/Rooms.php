<?php

namespace App\JungleStay;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rooms extends Model
{
    use SoftDeletes;

    protected $table = "js_rooms";

    protected $fillable = ["display_order", "js_id", "js_type", "no_of_rooms", "logo", "max_capacity", "display_price", "maintaince_charge", "amenities", "status", "created_at", "updated_at", "deleted_at"];

    protected $hidden = ["created_at", "updated_at"];

    protected $dates = ['deleted_at'];

}
