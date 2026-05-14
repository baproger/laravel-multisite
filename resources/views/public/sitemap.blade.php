<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach(['ru', 'kz'] as $locale)
    <url>
        <loc>{{ url($locale) }}</loc>
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>{{ url($locale . '/about') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ url($locale . '/services') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>
    <url>
        <loc>{{ url($locale . '/news') }}</loc>
        <changefreq>daily</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ url($locale . '/contacts') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    @foreach(\App\Models\Service::published()->get() as $service)
        @php $slug = $service->{"slug_{$locale}"} ?: $service->slug_ru; @endphp
        @if($slug)
        <url>
            <loc>{{ url($locale . '/services/' . $slug) }}</loc>
            <changefreq>monthly</changefreq>
            <priority>0.7</priority>
        </url>
        @endif
    @endforeach
    @foreach(\App\Models\News::where('status','published')->get() as $news)
        @php $slug = $news->{"slug_{$locale}"} ?: $news->slug_ru; @endphp
        @if($slug)
        <url>
            <loc>{{ url($locale . '/news/' . $slug) }}</loc>
            <changefreq>monthly</changefreq>
            <priority>0.6</priority>
        </url>
        @endif
    @endforeach
    @foreach(\App\Models\Page::where('status','published')->get() as $page)
        @php $slug = $page->{"slug_{$locale}"} ?: $page->slug_ru; @endphp
        @if($slug)
        <url>
            <loc>{{ url($locale . '/' . $slug) }}</loc>
            <changefreq>monthly</changefreq>
            <priority>0.5</priority>
        </url>
        @endif
    @endforeach
    @endforeach
</urlset>
