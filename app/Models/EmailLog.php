<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    protected $fillable = [
        'user_id',
        'user_type',
        'send_to',
        'subject',
        'desc',
        'response',
        'send_date',
    ];
}
