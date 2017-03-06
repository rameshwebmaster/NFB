<?php

namespace App;

use App\Traits\Metable;
use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    use Metable, Translatable;

    protected $fillable = ['title', 'body', 'excerpt', 'format', 'status', 'access', 'author', 'type'];

    protected $dates = ['deleted_at'];

    public function mainAttachment()
    {
        return $this->belongsToMany(Attachment::class, 'post_attachments', 'post_id', 'attachment_id')->wherePivot('type', 'main');
    }

    public function attachments()
    {
        return $this->belongsToMany(Attachment::class, 'post_attachments', 'post_id', 'attachment_id')->withPivot('type');
    }

    public function writer()
    {
        return $this->belongsTo(User::class, 'author');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'post_categories');
    }

    public function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    public function addTranslationItem($key, $value)
    {
        $this->attributes['translations'][$key] = $value;
    }
}
