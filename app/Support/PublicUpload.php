<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;

class PublicUpload
{
    public static function store(UploadedFile $file, string $directory): array
    {
        $path = $file->store($directory, 'public');

        return [
            'path' => $path,
            'url' => self::url($path),
        ];
    }

    public static function url(string $path): string
    {
        return '/storage/' . ltrim($path, '/');
    }
}
