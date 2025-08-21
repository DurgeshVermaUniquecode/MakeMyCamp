<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    protected $table = 'document_type';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'type','business_category_id'];

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y H:i A');
    }

    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y H:i A');
    }

    public function user_documents(){
        return $this->hasMany(UserDocument::class);
    }

    public function business_category(){
        return $this->belongsTo(BusinessCategory::class);
    }
}
