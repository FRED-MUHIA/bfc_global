<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaAsset extends Model
{
    protected $fillable = [
        'name',
        'original_name',
        'path',
        'url',
        'mime_type',
        'size',
    ];

    public function isImage(): bool
    {
        return str_starts_with((string) $this->mime_type, 'image/');
    }

    public function formattedSize(): string
    {
        if ($this->size >= 1048576) {
            return round($this->size / 1048576, 2) . ' MB';
        }

        return round($this->size / 1024, 1) . ' KB';
    }
}
