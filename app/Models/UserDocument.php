<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDocument extends Model
{
    protected $table = 'user_documents';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id','package_id','document_type_id','business_category_id','name','path','status','deleted_at','added_by'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function package(){
        return $this->belongsTo(Packages::class);
    }

    public function document_type(){
        return $this->belongsTo(DocumentType::class);
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
