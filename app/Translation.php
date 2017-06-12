<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{

	protected $table = 'translations';

    protected $fillable = ['key', 'value', 'lang','translatable_type'];

    public $timestamps = false;

    public function translatable()
    {
        $this->morphTo();
    }

}
