@php
    $locale = $locale ?? app()->getLocale();
    $navLinks = [
        ['route' => 'home',     'label_ru' => 'Главная',    'label_kz' => 'Басты бет',   'label_en' => 'Home'],
        ['route' => 'about',    'label_ru' => 'О компании', 'label_kz' => 'Біз туралы',  'label_en' => 'About'],
        ['route' => 'services', 'label_ru' => 'Услуги',     'label_kz' => 'Қызметтер',   'label_en' => 'Services'],
        ['route' => 'news',     'label_ru' => 'Новости',    'label_kz' => 'Жаңалықтар',  'label_en' => 'News'],
        ['route' => 'contacts', 'label_ru' => 'Контакты',   'label_kz' => 'Байланыс',    'label_en' => 'Contacts'],
    ];
@endphp

<header x-data="{ open: false, scrolled: false }"
        x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 20 })"
        :class="scrolled ? 'bg-white shadow-md' : 'bg-white/95 backdrop-blur-sm'"
        class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-20">

            {{-- Логотип --}}
            <a href="{{ route('home', $locale) }}"
               class="flex items-center space-x-3 group">
                <div class="w-9 h-9 bg-gradient-to-br from-blue-600 to-blue-800 rounded-lg flex items-center justify-center shadow-md group-hover:shadow-blue-300 transition-shadow duration-300">
                    <span class="text-white font-bold text-sm">CО</span>
                </div>
                <span class="font-bold text-xl text-gray-900 tracking-tight group-hover:text-blue-700 transition-colors duration-200">
                    {{ config('app.name') }}
                </span>
            </a>

            {{-- Десктоп навигация --}}
            <nav class="hidden lg:flex items-center space-x-1">
                @foreach($navLinks as $link)
                    @php
                        $label = $link['label_' . $locale] ?? $link['label_ru'];
                        $isActive = request()->routeIs($link['route']);
                    @endphp
                    <a href="{{ route($link['route'], $locale) }}"
                       class="relative px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200
                              {{ $isActive
                                  ? 'text-blue-700 bg-blue-50'
                                  : 'text-gray-600 hover:text-blue-700 hover:bg-blue-50' }}">
                        {{ $label }}
                        @if($isActive)
                            <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-4 h-0.5 bg-blue-600 rounded-full"></span>
                        @endif
                    </a>
                @endforeach
            </nav>

            {{-- Правая часть: переключатель языка + мобильное меню --}}
            <div class="flex items-center space-x-3">

                {{-- Переключатель языка --}}
                <div x-data="{ langOpen: false }" class="relative">
                    <button @click="langOpen = !langOpen"
                            class="flex items-center space-x-1.5 px-3 py-1.5 bg-gray-100 hover:bg-blue-50 text-gray-700 hover:text-blue-700 rounded-lg text-sm font-medium transition-all duration-200 border border-transparent hover:border-blue-200">
                        <span class="text-base leading-none">
                            @if($locale === 'kz') 🇰🇿
                            @elseif($locale === 'en') 🇬🇧
                            @else 🇷🇺
                            @endif
                        </span>
                        <span class="uppercase text-xs font-semibold tracking-wide">{{ $locale }}</span>
                        <svg class="w-3 h-3 transition-transform duration-200" :class="langOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div x-show="langOpen"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         @click.outside="langOpen = false"
                         class="absolute right-0 top-full mt-2 w-32 bg-white rounded-xl shadow-xl border border-gray-100 py-1 z-50">
                        @foreach(['ru' => ['🇷🇺', 'Русский'], 'kz' => ['🇰🇿', 'Қазақша'], 'en' => ['🇬🇧', 'English']] as $lang => [$flag, $name])
                            @php
                                // Формируем URL той же страницы, но с другим языком
                                $currentRoute = request()->route()->getName();
                                try {
                                    $langUrl = route($currentRoute, array_merge(request()->route()->parameters(), ['locale' => $lang]));
                                } catch (\Exception $e) {
                                    $langUrl = route('home', $lang);
                                }
                            @endphp
                            <a href="{{ $langUrl }}"
                               class="flex items-center space-x-2 px-3 py-2 text-sm {{ $locale === $lang ? 'text-blue-700 bg-blue-50 font-medium' : 'text-gray-700 hover:bg-gray-50' }} transition-colors duration-150">
                                <span>{{ $flag }}</span>
                                <span>{{ $name }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Кнопка связи --}}
                <a href="{{ route('contacts', $locale) }}"
                   class="hidden sm:inline-flex items-center px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-medium rounded-lg transition-all duration-200 shadow-sm hover:shadow-blue-300">
                    @if($locale === 'kz') Байланыс
                    @elseif($locale === 'en') Contact us
                    @else Связаться
                    @endif
                </a>

                {{-- Гамбургер (мобильный) --}}
                <button @click="open = !open"
                        class="lg:hidden p-2 rounded-lg text-gray-600 hover:text-blue-700 hover:bg-blue-50 transition-colors duration-200">
                    <svg x-show="!open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Мобильное меню --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="lg:hidden bg-white border-t border-gray-100 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-3 space-y-1">
            @foreach($navLinks as $link)
                @php $label = $link['label_' . $locale] ?? $link['label_ru']; @endphp
                <a href="{{ route($link['route'], $locale) }}"
                   @click="open = false"
                   class="block px-4 py-2.5 text-sm font-medium rounded-lg text-gray-700 hover:text-blue-700 hover:bg-blue-50 transition-colors duration-150 {{ request()->routeIs($link['route']) ? 'text-blue-700 bg-blue-50' : '' }}">
                    {{ $label }}
                </a>
            @endforeach
            <div class="pt-2 border-t border-gray-100">
                <a href="{{ route('contacts', $locale) }}"
                   class="block w-full text-center px-4 py-2.5 bg-blue-700 hover:bg-blue-800 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                    @if($locale === 'kz') Байланыс @elseif($locale === 'en') Contact us @else Связаться @endif
                </a>
            </div>
        </div>
    </div>
</header>

{{-- Отступ под фиксированным хедером --}}
<div class="h-16 lg:h-20"></div>
