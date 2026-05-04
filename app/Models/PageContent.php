<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'description',
        'hero',
        'sections',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'hero' => 'array',
            'sections' => 'array',
            'is_published' => 'boolean',
        ];
    }
}
