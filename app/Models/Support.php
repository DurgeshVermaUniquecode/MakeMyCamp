<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    protected $table = 'supports';

    protected $primaryKey = 'id';

    protected $fillable = [
                            'code', 
                            'for', 
                            'user_id', 
                            'subject',
                            'assigned_by',
                            'assigned_to',
                            'assign_date',
                            'status',
                        ];

    protected $casts = ['updated_at' => 'datetime','created_at' => 'datetime'];

    
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function assigner() {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function assignee() {
        return $this->belongsTo(User::class, 'assigned_to');
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
