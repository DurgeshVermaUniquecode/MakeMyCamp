<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Steps extends Model
{
    protected $table = 'steps';
    protected $primaryKey = 'id';
    protected $fillable = ['title','icon','order','status'];

     public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y H:i A');
    }

    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y H:i A');
    }
}
