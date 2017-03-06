<?php

namespace App;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    use Translatable;

    public $fillable = ['title', 'slug', 'type', 'count', 'description', 'order'];

    public function addTranslationItem($key, $value)
    {
        $this->attributes['translations'][$key] = $value;
    }

}
