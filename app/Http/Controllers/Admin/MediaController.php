<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $query = Media::with('uploader')->latest();

        if ($request->filled('type')) {
            $query->where('mime_type', 'like', $request->type . '/%');
        }

        $files = $query->paginate(24);
        return view('admin.media.index', compact('files'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'files'   => 'required|array',
            'files.*' => 'required|file|mimes:jpg,jpeg,png,webp,gif,pdf,doc,docx|max:10240',
        ], [
            'files.required'   => 'Выберите файлы для загрузки',
            'files.*.mimes'    => 'Допустимые форматы: jpg, png, webp, gif, pdf, doc, docx',
            'files.*.max'      => 'Максимальный размер файла: 10 МБ',
        ]);

        $uploaded = [];

        foreach ($request->file('files') as $file) {
            $path = $file->store('media/' . date('Y/m'), 'public');

            $media = Media::create([
                'filename'      => basename($path),
                'original_name' => $file->getClientOriginalName(),
                'path'          => $path,
                'disk'          => 'public',
                'mime_type'     => $file->getMimeType(),
                'size'          => $file->getSize(),
                'collection'    => 'default',
                'uploaded_by'   => auth()->id(),
            ]);

            $uploaded[] = [
                'id'  => $media->id,
                'url' => $media->url,
                'name'=> $media->original_name,
            ];
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'files' => $uploaded]);
        }

        return back()->with('success', 'Файлы загружены: ' . count($uploaded));
    }

    public function destroy(int $id)
    {
        $media = Media::findOrFail($id);
        Storage::disk($media->disk)->delete($media->path);
        $media->forceDelete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Файл удалён');
    }
}
