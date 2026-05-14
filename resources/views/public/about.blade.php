@extends('layouts.app')

@section('title',
    $locale === 'kz' ? 'Біз туралы' :
    ($locale === 'en' ? 'About Us' : 'О нас')
)

@section('content')

{{-- Hero --}}
<section class="relative bg-gradient-to-br from-blue-950 via-blue-900 to-blue-800 text-white py-16 lg:py-24">
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-block text-blue-300 text-sm font-semibold uppercase tracking-widest mb-4">
            @if($locale === 'kz') Компания туралы @elseif($locale === 'en') About the Company @else О компании @endif
        </span>
        <h1 class="text-4xl sm:text-5xl font-bold mb-6">
            @if($locale === 'kz') Біз туралы @elseif($locale === 'en') About Us @else О нас @endif
        </h1>
        <p class="text-blue-200 text-lg max-w-2xl mx-auto">
            @if($locale === 'kz')
                Кәсіби командамыз сіздің бизнесіңіздің өсуіне бағытталған.
            @elseif($locale === 'en')
                Our professional team is dedicated to growing your business.
            @else
                Наша профессиональная команда нацелена на рост вашего бизнеса.
            @endif
        </p>
    </div>
</section>

{{-- Миссия --}}
<section class="py-16 lg:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto text-center">
            <span class="text-blue-600 text-sm font-semibold uppercase tracking-widest">
                @if($locale === 'kz') Миссия @elseif($locale === 'en') Mission @else Миссия @endif
            </span>
            <h2 class="mt-3 text-3xl lg:text-4xl font-bold text-gray-900 mb-6">
                @if($locale === 'kz') Біздің миссиямыз @elseif($locale === 'en') Our Mission @else Наша миссия @endif
            </h2>
            <p class="text-gray-600 text-lg leading-relaxed">
                @if($locale === 'kz')
                    Клиенттерімізге ең жоғары сапалы қызметтер мен шешімдер ұсына отырып, олардың бизнесін дамытуға ықпал ету.
                @elseif($locale === 'en')
                    To contribute to the development of our clients' businesses by providing the highest quality services and solutions.
                @else
                    Содействовать развитию бизнеса наших клиентов, предоставляя услуги и решения высочайшего качества.
                @endif
            </p>
        </div>
    </div>
</section>

{{-- Команда --}}
@if($team->count())
<section class="py-16 lg:py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="text-blue-600 text-sm font-semibold uppercase tracking-widest">
                @if($locale === 'kz') Команда @elseif($locale === 'en') Team @else Команда @endif
            </span>
            <h2 class="mt-3 text-3xl lg:text-4xl font-bold text-gray-900">
                @if($locale === 'kz') Біздің мамандар @elseif($locale === 'en') Meet Our Team @else Наши специалисты @endif
            </h2>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($team as $member)
                <div class="bg-white rounded-2xl p-6 text-center shadow-sm hover:shadow-md transition-shadow duration-300 group">
                    <div class="relative mx-auto w-24 h-24 mb-4">
                        @if($member->photo_url ?? false)
                            <img src="{{ $member->photo_url }}" alt="{{ $member->getName($locale) }}"
                                 class="w-24 h-24 rounded-2xl object-cover shadow-md">
                        @else
                            <div class="w-24 h-24 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center text-white text-2xl font-bold shadow-md">
                                {{ strtoupper(substr($member->getName($locale), 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <h3 class="font-semibold text-gray-900 text-sm">{{ $member->getName($locale) }}</h3>
                    @if($member->getPosition($locale))
                        <p class="text-gray-500 text-xs mt-1">{{ $member->getPosition($locale) }}</p>
                    @endif
                    @if($member->email || $member->linkedin)
                        <div class="flex justify-center space-x-2 mt-3">
                            @if($member->email)
                                <a href="mailto:{{ $member->email }}" class="text-gray-300 hover:text-blue-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </a>
                            @endif
                            @if($member->linkedin)
                                <a href="{{ $member->linkedin }}" target="_blank" class="text-gray-300 hover:text-blue-600 transition-colors">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Партнёры --}}
@if($partners->count())
<section class="py-12 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-center text-gray-400 text-sm uppercase tracking-widest mb-8">
            @if($locale === 'kz') Серіктестер @elseif($locale === 'en') Partners @else Партнёры @endif
        </p>
        <div class="flex flex-wrap justify-center items-center gap-10">
            @foreach($partners as $partner)
                <div class="grayscale hover:grayscale-0 opacity-50 hover:opacity-100 transition-all duration-300">
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

{{-- CTA --}}
<section class="py-16 bg-gradient-to-br from-blue-700 to-blue-900 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold mb-4">
            @if($locale === 'kz') Бізбен байланысыңыз @elseif($locale === 'en') Get in Touch @else Свяжитесь с нами @endif
        </h2>
        <p class="text-blue-200 mb-8">
            @if($locale === 'kz') Сұрақтарыңыз бар ма? Бізге жазыңыз!
            @elseif($locale === 'en') Have questions? Write to us!
            @else Есть вопросы? Напишите нам!
            @endif
        </p>
        <a href="{{ route('contacts', $locale) }}"
           class="inline-flex items-center px-8 py-4 bg-white text-blue-700 font-bold rounded-xl hover:bg-blue-50 transition-all duration-200 shadow-xl hover:-translate-y-0.5">
            @if($locale === 'kz') Байланыс @elseif($locale === 'en') Contact Us @else Написать @endif
        </a>
    </div>
</section>

@endsection
