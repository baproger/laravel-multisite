<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNewsRequest;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = News::withTrashed()->with('author')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title_ru', 'like', "%{$search}%")
                  ->orWhere('title_kz', 'like', "%{$search}%")
                  ->orWhere('title_en', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'trash') {
                $query->onlyTrashed();
            } else {
                $query->withoutTrashed()->where('status', $request->status);
            }
        }

        $news = $query->paginate(15)->withQueryString();

        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(StoreNewsRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = auth()->id();

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->file('image'));
        }

        // Автоматически генерировать slug_kz/slug_en из slug_ru если не заполнены
        if (empty($data['slug_kz'])) $data['slug_kz'] = $data['slug_ru'] . '-kz';
        if (empty($data['slug_en'])) $data['slug_en'] = $data['slug_ru'];

        News::create($data);

        return redirect()->route('admin.news.index')
            ->with('success', 'Новость успешно создана');
    }

    public function show(int $id)
    {
        $news = News::withTrashed()->findOrFail($id);
        return view('admin.news.show', compact('news'));
    }

    public function edit(int $id)
    {
        $news = News::withTrashed()->findOrFail($id);
        return view('admin.news.edit', compact('news'));
    }

    public function update(StoreNewsRequest $request, int $id)
    {
        $news = News::withTrashed()->findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('image')) {
            // Удалить старое изображение
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
            $data['image'] = $this->uploadImage($request->file('image'));
        }

        $news->update($data);

        return redirect()->route('admin.news.index')
            ->with('success', 'Новость успешно обновлена');
    }

    public function destroy(int $id)
    {
        $news = News::withTrashed()->findOrFail($id);

        if ($news->trashed()) {
            // Окончательное удаление
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
            $news->forceDelete();
            return back()->with('success', 'Новость удалена окончательно');
        }

        $news->delete(); // Soft delete
        return back()->with('success', 'Новость перемещена в корзину');
    }

    public function restore(int $id)
    {
        News::onlyTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Новость восстановлена');
    }

    public function preview(int $id)
    {
        $news = News::withTrashed()->findOrFail($id);
        $locale = 'ru';
        return view('public.news.show', compact('news', 'locale'));
    }

    private function uploadImage($file): string
    {
        return $file->store('news', 'public');
    }
}
