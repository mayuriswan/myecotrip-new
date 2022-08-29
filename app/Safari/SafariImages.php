<?php

namespace App\Safari;

use Illuminate\Database\Eloquent\Model;

class SafariImages extends Model
{
    protected $table = "safariImages";

    protected $fillable = [ "safari_id", "name", "status"];
}
