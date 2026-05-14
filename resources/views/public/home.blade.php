@extends('layouts.app')

@section('title', __('nav.home'))

@section('content')

{{-- ===== HERO SECTION ===== --}}
<section class="relative overflow-hidden bg-gradient-to-br from-blue-950 via-blue-900 to-blue-800 text-white">
    {{-- Декоративные элементы --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-blue-400/10 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-blue-600/10 rounded-full blur-3xl"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
        <div class="max-w-3xl">
            {{-- Бейдж --}}
            <div class="inline-flex items-center space-x-2 bg-blue-500/20 border border-blue-400/30 rounded-full px-4 py-1.5 mb-6 backdrop-blur-sm">
                <span class="w-1.5 h-1.5 bg-blue-400 rounded-full animate-pulse"></span>
                <span class="text-blue-200 text-sm font-medium">
                    @if($locale === 'kz') Кәсіби қызметтер @elseif($locale === 'en') Professional Services @else Профессиональные услуги @endif
                </span>
            </div>

            {{-- Заголовок --}}
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight mb-6 tracking-tight">
                @if($locale === 'kz')
                    Сіздің бизнесіңізге<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-300 to-cyan-300">сенімді серіктес</span>
                @elseif($locale === 'en')
                    Your trusted partner<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-300 to-cyan-300">for business growth</span>
                @else
                    Надёжный партнёр<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-300 to-cyan-300">для вашего бизнеса</span>
                @endif
            </h1>

            <p class="text-blue-100 text-lg lg:text-xl leading-relaxed mb-8 max-w-2xl">
                @if($locale === 'kz')
                    Сіздің бизнесіңіздің өсуіне ықпал ететін кешенді шешімдер мен кәсіби қызметтер ұсынамыз.
                @elseif($locale === 'en')
                    We offer comprehensive solutions and professional services to drive your business growth.
                @else
                    Предлагаем комплексные решения и профессиональные услуги для роста вашего бизнеса.
                @endif
            </p>

            <div class="flex flex-wrap gap-4">
                <a href="{{ route('services', $locale) }}"
                   class="inline-flex items-center px-6 py-3 bg-white text-blue-700 font-semibold rounded-xl hover:bg-blue-50 transition-all duration-200 shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                    @if($locale === 'kz') Қызметтерді көру @elseif($locale === 'en') View Services @else Наши услуги @endif
                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
                <a href="{{ route('contacts', $locale) }}"
                   class="inline-flex items-center px-6 py-3 bg-blue-500/20 border border-blue-400/40 text-white font-semibold rounded-xl hover:bg-blue-500/30 transition-all duration-200 backdrop-blur-sm">
                    @if($locale === 'kz') Байланыс @elseif($locale === 'en') Contact Us @else Связаться @endif
                </a>
            </div>

            {{-- Статистика --}}
            <div class="flex flex-wrap gap-8 mt-12 pt-12 border-t border-blue-700/50">
                @foreach([['10+', 'лет опыта', 'жыл тәжірибе', 'years experience'], ['500+', 'проектов', 'жоба', 'projects'], ['98%', 'довольных клиентов', 'қанағат клиент', 'satisfied clients']] as [$num, $ru, $kz, $en])
                    <div>
                        <div class="text-3xl font-bold text-white">{{ $num }}</div>
                        <div class="text-blue-300 text-sm mt-0.5">
                            @if($locale === 'kz') {{ $kz }} @elseif($locale === 'en') {{ $en }} @else {{ $ru }} @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ===== УСЛУГИ ===== --}}
@if($services->count())
<section class="py-16 lg:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Заголовок секции --}}
        <div class="text-center mb-12">
            <span class="text-blue-600 text-sm font-semibold uppercase tracking-widest">
                @if($locale === 'kz') Қызметтер @elseif($locale === 'en') Services @else Услуги @endif
            </span>
            <h2 class="mt-2 text-3xl lg:text-4xl font-bold text-gray-900">
                @if($locale === 'kz') Біз не ұсынамыз @elseif($locale === 'en') What We Offer @else Что мы предлагаем @endif
            </h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($services as $service)
                <a href="{{ route('services.show', [$locale, $service->getSlug($locale)]) }}"
                   class="group p-6 bg-white border border-gray-100 rounded-2xl hover:border-blue-200 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    {{-- Иконка --}}
                    <div class="w-12 h-12 bg-blue-50 group-hover:bg-blue-100 rounded-xl flex items-center justify-center mb-4 transition-colors duration-200">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    {{-- Изображение --}}
                    @if($service->image_url)
                        <img src="{{ $service->image_url }}" alt="{{ $service->getTitle($locale) }}"
                             class="w-full h-40 object-cover rounded-xl mb-4">
                    @endif
                    <h3 class="font-semibold text-gray-900 group-hover:text-blue-700 transition-colors duration-200 mb-2">
                        {{ $service->getTitle($locale) }}
                    </h3>
                    @if($service->getDescription($locale))
                        <p class="text-gray-500 text-sm leading-relaxed line-clamp-2">
                            {{ $service->getDescription($locale) }}
                        </p>
                    @endif
                    <div class="mt-4 flex items-center text-blue-600 text-sm font-medium">
                        <span>@if($locale === 'kz') Толығырақ @elseif($locale === 'en') Learn more @else Подробнее @endif</span>
                        <svg class="ml-1 w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('services', $locale) }}"
               class="inline-flex items-center px-6 py-3 border-2 border-blue-700 text-blue-700 font-semibold rounded-xl hover:bg-blue-700 hover:text-white transition-all duration-200">
                @if($locale === 'kz') Барлық қызметтер @elseif($locale === 'en') All Services @else Все услуги @endif
            </a>
        </div>
    </div>
</section>
@endif

{{-- ===== НОВОСТИ ===== --}}
@if($latestNews->count())
<section class="py-16 lg:py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-10">
            <div>
                <span class="text-blue-600 text-sm font-semibold uppercase tracking-widest">
                    @if($locale === 'kz') Жаңалықтар @elseif($locale === 'en') Latest News @else Новости @endif
                </span>
                <h2 class="mt-2 text-3xl lg:text-4xl font-bold text-gray-900">
                    @if($locale === 'kz') Соңғы жаңалықтар @elseif($locale === 'en') What's happening @else Последние события @endif
                </h2>
            </div>
            <a href="{{ route('news', $locale) }}"
               class="hidden sm:inline-flex items-center text-blue-600 font-medium hover:text-blue-800 transition-colors">
                @if($locale === 'kz') Барлығы @elseif($locale === 'en') View all @else Все новости @endif
                <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($latestNews as $item)
                <a href="{{ route('news.show', [$locale, $item->getSlug($locale)]) }}"
                   class="group bg-white rounded-2xl overflow-hidden border border-gray-100 hover:border-blue-100 hover:shadow-lg transition-all duration-300">
                    @if($item->image_url)
                        <div class="aspect-video overflow-hidden">
                            <img src="{{ $item->image_url }}" alt="{{ $item->getTitle($locale) }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                    @else
                        <div class="aspect-video bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                            <svg class="w-12 h-12 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                            </svg>
                        </div>
                    @endif
                    <div class="p-5">
                        <p class="text-gray-400 text-xs mb-2">
                            {{ $item->published_at ? $item->published_at->format('d.m.Y') : $item->created_at->format('d.m.Y') }}
                        </p>
                        <h3 class="font-semibold text-gray-900 group-hover:text-blue-700 transition-colors duration-200 line-clamp-2 mb-2">
                            {{ $item->getTitle($locale) }}
                        </h3>
                        @if($item->getDescription($locale))
                            <p class="text-gray-500 text-sm line-clamp-2">{{ $item->getDescription($locale) }}</p>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ===== КОМАНДА ===== --}}
@if($team->count())
<section class="py-16 lg:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="text-blue-600 text-sm font-semibold uppercase tracking-widest">
                @if($locale === 'kz') Команда @elseif($locale === 'en') Our Team @else Команда @endif
            </span>
            <h2 class="mt-2 text-3xl lg:text-4xl font-bold text-gray-900">
                @if($locale === 'kz') Біздің мамандар @elseif($locale === 'en') Meet Our Experts @else Наши специалисты @endif
            </h2>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($team as $member)
                <div class="text-center group">
                    <div class="relative mx-auto w-24 h-24 mb-4">
                        <img src="{{ $member->photo_url }}" alt="{{ $member->getName($locale) }}"
                             class="w-24 h-24 rounded-2xl object-cover shadow-md group-hover:shadow-blue-200 transition-shadow duration-300">
                    </div>
                    <h3 class="font-semibold text-gray-900 text-sm">{{ $member->getName($locale) }}</h3>
                    @if($member->getPosition($locale))
                        <p class="text-gray-500 text-xs mt-0.5">{{ $member->getPosition($locale) }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ===== ПАРТНЁРЫ ===== --}}
@if($partners->count())
<section class="py-12 bg-gray-50 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-center text-gray-400 text-sm uppercase tracking-widest mb-8">
            @if($locale === 'kz') Серіктестер @elseif($locale === 'en') Our Partners @else Партнёры и клиенты @endif
        </p>
        <div class="flex flex-wrap justify-center items-center gap-8">
            @foreach($partners as $partner)
                <div class="grayscale hover:grayscale-0 opacity-60 hover:opacity-100 transition-all duration-300">
                    @if($partner->logo_url)
                        <img src="{{ $partner->logo_url }}" alt="{{ $partner->getName($locale) }}"
                             class="h-10 object-contain max-w-[120px]">
                    @else
                        <span class="text-gray-600 font-semibold text-sm">{{ $partner->getName($locale) }}</span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ===== FAQ ===== --}}
@if($faqs->count())
<section class="py-16 lg:py-24 bg-white">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="text-blue-600 text-sm font-semibold uppercase tracking-widest">FAQ</span>
            <h2 class="mt-2 text-3xl lg:text-4xl font-bold text-gray-900">
                @if($locale === 'kz') Жиі қойылатын сұрақтар @elseif($locale === 'en') Frequently Asked Questions @else Часто задаваемые вопросы @endif
            </h2>
        </div>

        <div class="space-y-3" x-data="{ active: null }">
            @foreach($faqs as $i => $faq)
                <div class="border border-gray-200 rounded-xl overflow-hidden hover:border-blue-200 transition-colors duration-200">
                    <button @click="active === {{ $i }} ? active = null : active = {{ $i }}"
                            class="w-full text-left px-5 py-4 flex items-center justify-between font-medium text-gray-900 hover:text-blue-700 transition-colors duration-150">
                        <span class="pr-4">{{ $faq->getQuestion($locale) }}</span>
                        <svg :class="active === {{ $i }} ? 'rotate-180 text-blue-600' : 'text-gray-400'"
                             class="w-5 h-5 flex-shrink-0 transition-all duration-300"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="active === {{ $i }}"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="px-5 pb-4 text-gray-600 text-sm leading-relaxed border-t border-gray-100">
                        <div class="pt-3">{{ $faq->getAnswer($locale) }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ===== CTA ===== --}}
<section class="py-16 lg:py-20 bg-gradient-to-br from-blue-700 to-blue-900 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl lg:text-4xl font-bold mb-4">
            @if($locale === 'kz') Бізбен байланысыңыз @elseif($locale === 'en') Ready to work together? @else Готовы начать сотрудничество? @endif
        </h2>
        <p class="text-blue-200 text-lg mb-8">
            @if($locale === 'kz') Сізбен жұмыс істеуге дайынбыз. Бүгін хабарласыңыз!
            @elseif($locale === 'en') Contact us today and let's discuss your project.
            @else Свяжитесь с нами сегодня и обсудим ваш проект.
            @endif
        </p>
        <a href="{{ route('contacts', $locale) }}"
           class="inline-flex items-center px-8 py-4 bg-white text-blue-700 font-bold rounded-xl hover:bg-blue-50 transition-all duration-200 shadow-xl hover:shadow-2xl hover:-translate-y-0.5 text-lg">
            @if($locale === 'kz') Байланыс @elseif($locale === 'en') Get in Touch @else Написать нам @endif
            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </a>
    </div>
</section>

@endsection
