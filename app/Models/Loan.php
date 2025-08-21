<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $table = 'loans';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id','employee_id','amount','commission_amount','trans_number','trans_image','status','added_by'];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function employee(){
        return $this->belongsTo(User::class,'employee_id');
    }

    public function addedBy(){
        return $this->belongsTo(User::class,'added_by');
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
