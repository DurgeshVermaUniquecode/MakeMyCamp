<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessCategory extends Model
{
    protected $table = 'business_categories';
    protected $primaryKey = 'id';
    protected $fillable = ['package_id','business_category_id','name', 'image', 'description','document_type', 'status'];

    public function package()
    {
        return $this->belongsTo(Packages::class);
    }

    public function courses()
    {
        return $this->hasMany(Courses::class);
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
