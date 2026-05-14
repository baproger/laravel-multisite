<!DOCTYPE html>
<html lang="{{ $locale ?? 'ru' }}" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name')) | {{ config('app.name') }}</title>
    <meta name="description" content="@yield('meta_description', '')">
    <meta name="keywords" content="@yield('meta_keywords', '')">

    {{-- Canonical URL --}}
    <link rel="canonical" href="@yield('canonical', url()->current())">

    {{-- Open Graph --}}
    <meta property="og:title"       content="@yield('title', config('app.name'))">
    <meta property="og:description" content="@yield('meta_description', '')">
    <meta property="og:image"       content="@yield('og_image', asset('images/og-default.jpg'))">
    <meta property="og:url"         content="{{ url()->current() }}">
    <meta property="og:type"        content="website">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { inter: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'] }
                }
            }
        }
    </script>
    <style>
        .fade-up { opacity: 0; transform: translateY(24px); transition: all 0.7s ease-out; }
        .fade-up.animate-in { opacity: 1; transform: translateY(0); }
        .line-clamp-1 { overflow: hidden; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; }
        .line-clamp-2 { overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; }
        .line-clamp-3 { overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeIn   { from { opacity: 0; } to { opacity: 1; } }
        @keyframes pulse-glow { 0%,100% { box-shadow: 0 0 0 0 rgba(59,130,246,.4); } 50% { box-shadow: 0 0 0 8px rgba(59,130,246,0); } }
        .animate-fade-in-up { animation: fadeInUp 0.6s ease-out forwards; }
        .animate-fade-in    { animation: fadeIn 0.4s ease-out forwards; }
        .animate-pulse-glow { animation: pulse-glow 2s infinite; }
        .prose { color: #374151; line-height: 1.75; }
        .prose h2 { font-size: 1.5rem; font-weight: 700; color: #111827; margin: 2rem 0 1rem; }
        .prose h3 { font-size: 1.25rem; font-weight: 600; color: #111827; margin: 1.5rem 0 .75rem; }
        .prose p  { margin-bottom: 1rem; }
        .prose ul { list-style: disc inside; margin-bottom: 1rem; }
        .prose ol { list-style: decimal inside; margin-bottom: 1rem; }
        .prose a  { color: #2563eb; text-decoration: underline; }
        .prose blockquote { border-left: 4px solid #3b82f6; padding: .5rem 1rem; background: #eff6ff; border-radius: 0 .5rem .5rem 0; font-style: italic; }
        .prose img { border-radius: .75rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,.1); margin: 1.5rem 0; width: 100%; }
        .prose code { background: #f3f4f6; padding: .125rem .375rem; border-radius: .25rem; font-family: monospace; font-size: .875rem; }
        .prose pre  { background: #111827; color: #f9fafb; border-radius: .75rem; padding: 1.25rem; overflow-x: auto; font-family: monospace; font-size: .875rem; }
    </style>

    @stack('head')
</head>
<body class="font-inter antialiased bg-white text-gray-900">

    {{-- Прогресс-бар загрузки страницы --}}
    <div id="page-loader" class="fixed top-0 left-0 z-[9999] h-0.5 bg-blue-600 transition-all duration-300 w-0"></div>

    {{-- Навигация --}}
    @include('components.header')

    {{-- Основной контент --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

    {{-- Футер --}}
    @include('components.footer')

    {{-- Flash-сообщения --}}
    @include('components.flash')

    {{-- Alpine.js CDN (если не подключен через Vite) --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('scripts')

    <script>
        // Анимация загрузки страницы
        window.addEventListener('load', function() {
            const loader = document.getElementById('page-loader');
            loader.style.width = '100%';
            setTimeout(() => loader.style.opacity = '0', 300);
        });

        // Плавная прокрутка
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) target.scrollIntoView({ behavior: 'smooth' });
            });
        });

        // Анимация появления элементов
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));
    </script>
</body>
</html>
