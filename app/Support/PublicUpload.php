<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PublicUpload
{
    public static function store(UploadedFile $file, string $directory, bool $optimizeImages = true): array
    {
        if ($optimizeImages && self::canOptimize($file)) {
            $path = self::storeOptimizedImage($file, $directory);

            if ($path) {
                return [
                    'path' => $path,
                    'url' => self::url($path),
                ];
            }
        }

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

    private static function canOptimize(UploadedFile $file): bool
    {
        return extension_loaded('gd')
            && in_array($file->getMimeType(), ['image/jpeg', 'image/png', 'image/webp'], true);
    }

    private static function storeOptimizedImage(UploadedFile $file, string $directory): ?string
    {
        $sourcePath = $file->getRealPath();
        $mimeType = $file->getMimeType();

        $source = match ($mimeType) {
            'image/jpeg' => imagecreatefromjpeg($sourcePath),
            'image/png' => imagecreatefrompng($sourcePath),
            'image/webp' => imagecreatefromwebp($sourcePath),
            default => false,
        };

        if (! $source) {
            return null;
        }

        $width = imagesx($source);
        $height = imagesy($source);
        $maxDimension = 1800;
        $scale = min(1, $maxDimension / max($width, $height));
        $targetWidth = max(1, (int) round($width * $scale));
        $targetHeight = max(1, (int) round($height * $scale));

        $target = imagecreatetruecolor($targetWidth, $targetHeight);

        if (in_array($mimeType, ['image/png', 'image/webp'], true)) {
            imagealphablending($target, false);
            imagesavealpha($target, true);
        }

        imagecopyresampled($target, $source, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);

        $path = trim($directory, '/') . '/' . Str::uuid() . '.webp';
        $absolutePath = Storage::disk('public')->path($path);

        if (! is_dir(dirname($absolutePath))) {
            mkdir(dirname($absolutePath), 0755, true);
        }

        $saved = imagewebp($target, $absolutePath, 82);

        imagedestroy($source);
        imagedestroy($target);

        return $saved ? $path : null;
    }
}
