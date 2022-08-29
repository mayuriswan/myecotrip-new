<?php

namespace App\Safari;

use Illuminate\Database\Eloquent\Model;

class SafariEntryFee extends Model
{
    /**
     * The mapping between model with table.
     *
     * @var string
     */

    protected $table = 'safariEntryFee';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'safari_id','from_date','to_date','adult_price_india','child_price_india','senior_price_india','adult_price_foreign','child_price_foreign','senior_price_foreign','isActive'
    ];
}
