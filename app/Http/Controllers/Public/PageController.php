<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Page;

class PageController extends Controller
{
    public function show(string $locale, string $slug)
    {
        $page = Page::findBySlug($slug, $locale);

        if (!$page) {
            abort(404);
        }

        return view('public.page', compact('locale', 'page'));
    }
}
