<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersRequest extends Model
{
  protected $fillable = [
        'reg_number',
        'name',
        'email',
        'phonecode',
        'phone_number',
        'password',
        'role',
        'referral_id',
        'inteducior_id',
        'user_otp',
        'device_id',
        'opt_active',
        'country',
        'state',
        'city',
    ];

    protected $hidden = ['password', 'user_otp'];

}
