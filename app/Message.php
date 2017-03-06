<?php

namespace App;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    use Translatable;

    protected $fillable = ['subject', 'body', 'author'];

    protected $hidden = ['pivot', 'created_at', 'updated_at', 'author'];

    public function receivers()
    {
        return $this->belongsToMany(User::class, 'user_messages', 'message_id', 'user_id');
    }

    public function addTranslationItem($key, $value)
    {
        $this->attributes['translations'][$key] = $value;
    }

}
