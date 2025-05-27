<?php

namespace App\Models;

class BlogTagRelacion extends Model
{
    protected $table = 'blog_tags_relaciones';

    protected $fillable = [
        'blog_id',
        'tag_id'
    ];

    public $timestamps = false; // Esta tabla no necesita timestamps

    // Relaciones
    public function blog()
    {
        return $this->belongsTo(Blog::class, 'blog_id');
    }

    public function tag()
    {
        return $this->belongsTo(BlogTag::class, 'tag_id');
    }
}
