<?php

namespace App\JungleStay;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    protected $table = "js_room_types";

    protected $fillable = ["id", "name", "backend_key", "shortDesc", "bill_name", "type", "status", "created_at", "updated_at"];

    protected $hidden = ["created_at", "updated_at"];

}
