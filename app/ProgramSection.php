<?php

namespace App;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;

class ProgramSection extends Model
{

    use Translatable;

    protected $fillable = ['title', 'program_id'];

    public function entries()
    {
        return $this->hasMany(ProgramEntry::class, 'section_id');
    }

    public function addTranslationItem($key, $value)
    {
        $this->attributes['translations'][$key] = $value;
    }

}
