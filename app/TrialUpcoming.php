<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrialUpcoming extends Model
{
	protected $table = "trailUpcoming";
    protected $fillable = ["name", "shortDesc", "status", "googleSearchText", "created_at", "updated_at"];
}
