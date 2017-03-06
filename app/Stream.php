<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stream extends Model
{

    protected $fillable = ['filename', 'status', 'user_id'];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
