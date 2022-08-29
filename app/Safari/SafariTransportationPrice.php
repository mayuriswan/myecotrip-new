<?php

namespace App\Safari;

use Illuminate\Database\Eloquent\Model;

class SafariTransportationPrice extends Model
{
    /**
     * The mapping between model with table.
     *
     * @var string
     */

    protected $table = 'safariTransportationPrice';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'safari_id','transportation_id','adult_price_india','child_price_india','senior_price_india','adult_price_foreign','child_price_foreign','senior_price_foreign','no_of_seats','allow_seat_selection','isActive'
    ];
}
