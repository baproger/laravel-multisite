<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{News, Service, Page, ContactMessage, TeamMember, Partner, Faq};

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'news'            => News::count(),
            'news_published'  => News::published()->count(),
            'services'        => Service::count(),
            'pages'           => Page::count(),
            'team'            => TeamMember::count(),
            'partners'        => Partner::count(),
            'faq'             => Faq::count(),
            'messages'        => ContactMessage::count(),
            'messages_new'    => ContactMessage::new()->count(),
        ];

        $latestNews     = News::with('author')->latest()->take(5)->get();
        $latestMessages = ContactMessage::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'latestNews', 'latestMessages'));
    }
}
