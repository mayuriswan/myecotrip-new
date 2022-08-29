<?php

namespace App\JungleStay;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Images extends Model
{
    use SoftDeletes;

    protected $table = "js_images";

    protected $fillable = ["id", "js_id","room_id", "name","type", "s3_upload", "status", "created_at", "updated_at"];

    protected $hidden = ["created_at", "updated_at"];

    protected $dates = ['deleted_at'];

}
