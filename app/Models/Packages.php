<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Packages extends Model
{
    protected $table = 'packages';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'image', 'gst', 'amount','comission_amount', 'description', 'status'];

    public function business_category()
    {
        return $this->hasMany(BusinessCategory::class);
    }

    public function user_package()
    {
        return $this->hasOne(UserPackage::class);
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
