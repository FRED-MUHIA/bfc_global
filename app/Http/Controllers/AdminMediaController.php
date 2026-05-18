<?php

namespace App\Http\Controllers;

use App\Models\MediaAsset;
use App\Support\PublicUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminMediaController extends Controller
{
    public function index(): View
    {
        return view('admin.media.index', [
            'assets' => MediaAsset::query()->latest()->paginate(18),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'media' => $request->boolean('image_only')
                ? ['required', 'image', 'max:20480']
                : ['required', 'file', 'mimes:jpg,jpeg,png,webp,gif,svg,pdf,mp4,mov,webm', 'max:20480'],
            'name' => ['nullable', 'string', 'max:160'],
            'return_to' => ['nullable', 'string', 'in:dashboard'],
        ]);

        $file = $validated['media'];
        $upload = PublicUpload::store($file, 'media-library');
        $originalName = $file->getClientOriginalName();

        $asset = MediaAsset::query()->create([
            'name' => $validated['name'] ?: Str::headline(pathinfo($originalName, PATHINFO_FILENAME)),
            'original_name' => $originalName,
            'path' => $upload['path'],
            'url' => $upload['url'],
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize() ?: 0,
        ]);

        if (($validated['return_to'] ?? null) === 'dashboard') {
            return redirect()
                ->route('admin.dashboard')
                ->with('status', 'Image uploaded. Copy the link below to use it on any page.')
                ->with('uploaded_media_url', url($asset->url));
        }

        return redirect()
            ->route('admin.media.index')
            ->with('status', 'Media uploaded and link generated.');
    }

    public function destroy(MediaAsset $media): RedirectResponse
    {
        Storage::disk('public')->delete($media->path);
        $media->delete();

        return redirect()
            ->route('admin.media.index')
            ->with('status', 'Media deleted.');
    }
}
