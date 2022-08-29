<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parks extends Model
{

	protected $table = 'parks';   

    protected $fillable = ["display_order_no", "name", "type", "city", "logo", "direction", "transportation", "map_url", "description", "meta_title", "meta_description", "meta_keywords", "safari", "properties", "park", "ecotrails", "zoo", "status",'circle_id'];
}
