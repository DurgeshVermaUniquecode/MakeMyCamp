<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blogs';

    protected $fillable = [
        'id',
        'title',
        'slug',
        'content',
        'category_id',
        'image',
        'status',
    ];

    protected $casts = [
        'publish_datetime' => 'datetime',
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function getPublishDatetimeAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y H:i A');
    }
    
    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y H:i A');
    }

    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y H:i A');
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }
}
