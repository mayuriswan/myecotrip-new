<?php

namespace App\Safari;

use Illuminate\Database\Eloquent\Model;

class Safari extends Model
{
    /**
     * The mapping between model with table.
     *
     * @var string
     */

    protected $table = 'safari';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'display_order_no','park_id','name','logo','meta_title','meta_desc','keywords','description','includes','excludes','transportation_id','isActive'
    ];

}
