<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index(string $locale)
    {
        $services = Service::published()->ordered()->get();
        return view('public.services.index', compact('locale', 'services'));
    }

    public function show(string $locale, string $slug)
    {
        $service = Service::findBySlug($slug, $locale);

        if (!$service) {
            abort(404);
        }

        $related = Service::published()
            ->ordered()
            ->where('id', '!=', $service->id)
            ->take(3)
            ->get();

        return view('public.services.show', compact('locale', 'service', 'related'));
    }
}
