<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{

    protected $fillable = ['key', 'value', 'lang'];

    public $timestamps = false;

    public function translatable()
    {
        $this->morphTo();
    }

}
