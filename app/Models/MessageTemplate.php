<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageTemplate extends Model
{
    protected $fillable = [
        'value',
        'subject',
        'content',
        'variable',
        'tem_type',
        'category',
        'type',
        'status',
    ];

    protected $hidden = [
        'id',
    
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function find($value)
    {
        return $this->where('value', $value)->first();
    }

        public function getByTempNameForEmail($name)
    {  
        return $this->where('tem_type', 'EMAIL')->where('type', 'Non Campaign')->where('value', $name)->first(); 
    }

        public function getByTempNameForSMS($name)
    {  
        return $this->where('tem_type', 'SMS')->where('type', 'Non Campaign')->where('value', $name)->first(); 
    }

}
