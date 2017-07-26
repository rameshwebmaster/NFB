<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = ['user_id', 'type', 'expiry_date', 'start_date', 'status','receipt','purchase_id','device_type','receipt_status_code','status_code'];

    protected $dates = [
        'expiry_date',
        'start_date'
    ];

}
