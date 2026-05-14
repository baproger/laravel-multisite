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

    {{-- Vite assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

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
