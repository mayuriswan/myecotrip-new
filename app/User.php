<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    /**
     * The mapping between model with table.
     *
     * @var string
     */

    protected $table = 'users';     
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "first_name", "last_name", "contact_no", "email", "password", "address", "city", "state", "country", "last_login", "status", "device_id", "sign_in_with", "email_verified", "phone_verified", "otp"
    ];  

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
