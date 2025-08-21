<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnlinePayment extends Model
{
    protected $table = 'online_payments';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id','gateway_order_id','payment_id','ledger_id','amount','currency','gateway_request','gateway_response','gateway_name','status'];

}
