@extends('layouts.app')

@section('title', $locale === 'kz' ? 'Қызметтер' : ($locale === 'en' ? 'Services' : 'Услуги'))

@section('content')

<section class="bg-gradient-to-br from-blue-900 to-blue-800 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold mb-3">
            @if($locale === 'kz') Қызметтер @elseif($locale === 'en') Services @else Услуги @endif
        </h1>
        <p class="text-blue-200">
            @if($locale === 'kz') Біз ұсынатын кәсіби қызметтер
            @elseif($locale === 'en') Professional services we provide
            @else Профессиональные услуги, которые мы предоставляем
            @endif
        </p>
    </div>
</section>

<section class="py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($services->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($services as $service)
                    <a href="{{ route('services.show', [$locale, $service->getSlug($locale)]) }}"
                       class="group p-6 bg-white border border-gray-100 rounded-2xl hover:border-blue-200 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div class="w-12 h-12 bg-blue-50 group-hover:bg-blue-100 rounded-xl flex items-center justify-center mb-4 transition-colors duration-200">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        @if($service->image_url)
                            <img src="{{ $service->image_url }}" alt="{{ $service->getTitle($locale) }}"
                                 class="w-full h-40 object-cover rounded-xl mb-4">
                        @endif
                        <h2 class="font-bold text-gray-900 group-hover:text-blue-700 transition-colors duration-200 mb-2">
                            {{ $service->getTitle($locale) }}
                        </h2>
                        @if($service->getDescription($locale))
                            <p class="text-gray-500 text-sm leading-relaxed line-clamp-3">
                                {{ $service->getDescription($locale) }}
                            </p>
                        @endif
                        <div class="mt-4 flex items-center text-blue-600 text-sm font-medium">
                            @if($locale === 'kz') Толығырақ @elseif($locale === 'en') Learn more @else Подробнее @endif
                            <svg class="ml-1 w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-20">
                <p class="text-gray-400 text-lg">
                    @if($locale === 'kz') Қызметтер жоқ @elseif($locale === 'en') No services yet @else Услуг пока нет @endif
                </p>
            </div>
        @endif
    </div>
</section>

@endsection
