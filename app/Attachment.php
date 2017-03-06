<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    public $fillable = ['path', 'title', 'type', 'parent', 'size', 'size_name'];


    public function children()
    {
        return $this->hasMany(Attachment::class, 'parent', 'id');
    }

    public function squareSmall()
    {
        return $this->hasOne(Attachment::class, 'parent', 'id')->where('size', '300x300');
    }

    public function medium()
    {
        return $this->hasOne(Attachment::class, 'parent', 'id')->where('size', 'LIKE', '768x%');
    }

    public function sizes()
    {
        return $this->hasMany(Attachment::class, 'parent', 'id');
    }

    public function getParent()
    {
        return $this->belongsTo(Attachment::class, 'parent', 'id');
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_attachments', 'attachment_id', 'post_id')->withPivot('type');
    }

}
