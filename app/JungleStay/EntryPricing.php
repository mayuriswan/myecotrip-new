<?php

namespace App\JungleStay;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EntryPricing extends Model
{
    use SoftDeletes;

    protected $table = "js_entry_pricing";

    protected $fillable = ["id", "js_id", "pricing_id", "price", "status", "created_at", "updated_at", "deleted_at"];

    protected $hidden = ["created_at", "updated_at"];

    protected $dates = ['deleted_at'];
}
