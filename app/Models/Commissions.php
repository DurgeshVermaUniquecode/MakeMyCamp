<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Commissions extends Model
{
    protected $table = 'commisions';
    protected $primaryKey = 'id';
    protected $fillable = ['type','user_id','package_id','employee_id','amount'];

    public function package(){
        return $this->belongsTo(Packages::class);
    }

     public function user(){
        return $this->belongsTo(User::class);
    }

    public function employee(){
        return $this->belongsTo(User::class,'employee_id');
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
