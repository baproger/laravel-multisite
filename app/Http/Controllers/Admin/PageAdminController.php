<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePageRequest;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Page::withTrashed()->with('author')->ordered();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title_ru', 'like', "%{$search}%")
                  ->orWhere('slug_ru', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'trash') {
                $query = Page::onlyTrashed()->ordered();
            } else {
                $query->withoutTrashed()->where('status', $request->status);
            }
        }

        $pages = $query->paginate(15)->withQueryString();
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(StorePageRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = auth()->id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('pages', 'public');
        }

        Page::create($data);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Страница успешно создана');
    }

    public function show(int $id)
    {
        $page = Page::withTrashed()->findOrFail($id);
        return view('admin.pages.show', compact('page'));
    }

    public function edit(int $id)
    {
        $page = Page::withTrashed()->findOrFail($id);
        return view('admin.pages.edit', compact('page'));
    }

    public function update(StorePageRequest $request, int $id)
    {
        $page = Page::withTrashed()->findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($page->image) {
                Storage::disk('public')->delete($page->image);
            }
            $data['image'] = $request->file('image')->store('pages', 'public');
        }

        $page->update($data);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Страница успешно обновлена');
    }

    public function destroy(int $id)
    {
        $page = Page::withTrashed()->findOrFail($id);

        if ($page->trashed()) {
            if ($page->image) Storage::disk('public')->delete($page->image);
            $page->forceDelete();
            return back()->with('success', 'Страница удалена окончательно');
        }

        $page->delete();
        return back()->with('success', 'Страница перемещена в корзину');
    }

    public function restore(int $id)
    {
        Page::onlyTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Страница восстановлена');
    }

    public function preview(int $id)
    {
        $page = Page::withTrashed()->findOrFail($id);
        $locale = 'ru';
        return view('public.page', compact('page', 'locale'));
    }
}
