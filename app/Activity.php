<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{

    protected $fillable = ['user_id', 'ip_address', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
