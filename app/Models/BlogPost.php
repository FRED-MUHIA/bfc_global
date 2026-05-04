<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'excerpt',
        'category',
        'image',
        'author',
        'published_at',
        'date_label',
        'read_time',
        'content',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'date',
            'content' => 'array',
        ];
    }
}
