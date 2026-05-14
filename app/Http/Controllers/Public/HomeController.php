<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\{News, Service, TeamMember, Partner, Faq};

class HomeController extends Controller
{
    public function index(string $locale)
    {
        $latestNews  = News::published()->latest()->take(6)->get();
        $services    = Service::published()->ordered()->take(6)->get();
        $team        = TeamMember::published()->ordered()->take(8)->get();
        $partners    = Partner::published()->ordered()->take(12)->get();
        $faqs        = Faq::published()->ordered()->take(6)->get();

        return view('public.home', compact(
            'locale', 'latestNews', 'services', 'team', 'partners', 'faqs'
        ));
    }
}
