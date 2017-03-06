<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{

    protected $fillable = ['key', 'value', 'matable_id', 'metable_type'];

    public function matable()
    {
        return $this->morphTo();
    }

}
