<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Trail extends Model
{	
    use SoftDeletes;

	protected $table = "trails";

    protected $fillable = [ "id", "landscape_id", "park_id", "name", "seo_url", "range", "display_order_no", "max_trekkers", "max_offline_trekkers", "distance", "distance_unit", "hours", "minutes", "type", "description", "logo", "s3_upload", "display_price", "starting_point", "ending_point", "reporting_time", "when_to_visit", "incharger_details", "general_instruction", "meta_title", "meta_description", "meta_keywords", "direction", "transportation", "entrance_fee_version", "map_url", "status", "created_at", "updated_at", "deleted_at"];
    
    protected $hidden = ["created_at", "updated_at", "deleted_at"];

    protected $dates = ['deleted_at'];

}
