<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSteps extends Model
{
    protected $table = 'user_steps';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'step', 'order', 'icon', 'status'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y H:i A');
    }

    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y H:i A');
    }
}
