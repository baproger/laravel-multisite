<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\News;

class NewsController extends Controller
{
    public function index(string $locale)
    {
        $news = News::published()->latest()->paginate(9);
        return view('public.news.index', compact('locale', 'news'));
    }

    public function show(string $locale, string $slug)
    {
        $news = News::findBySlug($slug, $locale);

        if (!$news) {
            abort(404);
        }

        $news->incrementViews();

        $related = News::published()
            ->latest()
            ->where('id', '!=', $news->id)
            ->take(3)
            ->get();

        return view('public.news.show', compact('locale', 'news', 'related'));
    }
}
