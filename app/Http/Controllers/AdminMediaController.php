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
            'media' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,gif,svg,pdf,mp4,mov,webm', 'max:5120'],
            'name' => ['nullable', 'string', 'max:160'],
        ]);

        $file = $validated['media'];
        $upload = PublicUpload::store($file, 'media-library');
        $originalName = $file->getClientOriginalName();

        MediaAsset::query()->create([
            'name' => $validated['name'] ?: Str::headline(pathinfo($originalName, PATHINFO_FILENAME)),
            'original_name' => $originalName,
            'path' => $upload['path'],
            'url' => $upload['url'],
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize() ?: 0,
        ]);

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
