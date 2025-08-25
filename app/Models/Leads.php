<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leads extends Model
{
    protected $table = 'leads';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id','user_name','email','phone','company_name','address','source','source_description','assigned_to','assigned_date','created_by','status'];


    public function user(){
        return $this->belongsTo(User::class,'assigned_to');
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
