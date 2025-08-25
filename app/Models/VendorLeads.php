<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorLeads extends Model
{
    protected $table='vendor_leads';
    protected $primaryKey = 'id';
    protected $fillable = ['lead_id','user_id','assigned_to','status'];

    public function lead(){
        return $this->belongsTo(Leads::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
