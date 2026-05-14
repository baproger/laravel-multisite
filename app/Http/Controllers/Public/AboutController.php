<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\{TeamMember, Partner};

class AboutController extends Controller
{
    public function index(string $locale)
    {
        $team     = TeamMember::published()->ordered()->get();
        $partners = Partner::published()->ordered()->get();

        return view('public.about', compact('locale', 'team', 'partners'));
    }
}
