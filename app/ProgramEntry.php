<?php

namespace App;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;

class ProgramEntry extends Model
{

    use Translatable;

    protected $fillable = ['title', 'quantity', 'post_id', 'section_id', 'day', 'week'];

    public function addTranslationItem($key, $value)
    {
        $this->attributes['translations'][$key] = $value;
    }

    public function translations(){
    	return $this->hasMany(Translation::class, 'translatable_id');
    }

}
