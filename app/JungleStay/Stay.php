<?php

namespace App\JungleStay;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stay extends Model
{
    use SoftDeletes;

    protected $table = "jungle_stays";

    protected $fillable = ["id", "display_order", "name","address", "short_desc", "description", "general_instructions", "logo", "map_url", "incharger_details", "price_starting_from", "seo_url", "park_type", "has_trail", "trails", "has_safari", "safaries", "room_types", "meta_title", "meta_description", "meta_keywords", "status", "created_at", "updated_at", "deleted_at"];

    protected $hidden = ["created_at", "updated_at", "deleted_at"];
    protected $dates = ['deleted_at'];

}
