<?php

namespace App\BirdSanctuary;

use Illuminate\Database\Eloquent\Model;

class BirdSanctuaryAdmin extends Model
{
    /**
     * The mapping between model with table.
     *
     * @var string
     */

    protected $table = 'birdSanctuaryAdmins';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ["id", "name", "birdSanctuary_id", "email", "phone_no", "designation", "password", "status", "created_at", "updated_at" ];

    protected $hidden = [ "created_at", "updated_at"];
}
