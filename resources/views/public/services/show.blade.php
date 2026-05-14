@extends('layouts.app')

@section('title', $service->getMetaTitle($locale))
@section('meta_description', $service->getMetaDescription($locale))

@section('content')

<section class="bg-gradient-to-br from-blue-900 to-blue-800 text-white py-14">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center space-x-2 text-blue-300 text-sm mb-4">
            <a href="{{ route('home', $locale) }}" class="hover:text-white">@if($locale === 'kz') Басты @elseif($locale === 'en') Home @else Главная @endif</a>
            <span>/</span>
            <a href="{{ route('services', $locale) }}" class="hover:text-white">@if($locale === 'kz') Қызметтер @elseif($locale === 'en') Services @else Услуги @endif</a>
            <span>/</span>
            <span class="text-white">{{ $service->getTitle($locale) }}</span>
        </nav>
        <h1 class="text-3xl lg:text-4xl font-bold">{{ $service->getTitle($locale) }}</h1>
    </div>
</section>

<article class="py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($service->image_url)
            <img src="{{ $service->image_url }}" alt="{{ $service->getTitle($locale) }}"
                 class="w-full rounded-2xl shadow-lg mb-8 max-h-96 object-cover">
        @endif

        @if($service->getDescription($locale))
            <p class="text-xl text-gray-600 leading-relaxed border-l-4 border-blue-600 pl-5 mb-8 italic">
                {{ $service->getDescription($locale) }}
            </p>
        @endif

        @php $content = $service->getContent($locale); @endphp

        @if($content)
            <div class="prose prose-lg prose-blue max-w-none text-gray-700 leading-relaxed">
                {!! nl2br(e($content)) !!}
            </div>
        @else
            <div class="py-10 text-center text-gray-400">
                @if($locale === 'kz') Мазмұн толтырылмаған @elseif($locale === 'en') Content not available in this language @else Контент на данном языке не заполнен @endif
            </div>
        @endif

        <div class="mt-10 p-6 bg-blue-50 border border-blue-100 rounded-2xl">
            <h3 class="font-bold text-gray-900 mb-2">
                @if($locale === 'kz') Бізбен байланысыңыз @elseif($locale === 'en') Interested? Contact us @else Заинтересовала услуга? @endif
            </h3>
            <p class="text-gray-600 text-sm mb-4">
                @if($locale === 'kz') Бізге хабарлама жіберіңіз, жауап береміз
                @elseif($locale === 'en') Send us a message and we'll get back to you
                @else Оставьте заявку и мы свяжемся с вами
                @endif
            </p>
            <a href="{{ route('contacts', $locale) }}"
               class="inline-flex items-center px-5 py-2.5 bg-blue-700 hover:bg-blue-800 text-white font-medium rounded-xl transition-colors duration-200">
                @if($locale === 'kz') Байланыс @elseif($locale === 'en') Contact Us @else Связаться @endif
            </a>
        </div>

        <div class="mt-8 pt-6 border-t border-gray-200">
            <a href="{{ route('services', $locale) }}"
               class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium transition-colors">
                <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
                </svg>
                @if($locale === 'kz') Барлық қызметтер @elseif($locale === 'en') All Services @else Все услуги @endif
            </a>
        </div>
    </div>
</article>

@if($related->count())
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">
            @if($locale === 'kz') Басқа қызметтер @elseif($locale === 'en') Other Services @else Другие услуги @endif
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            @foreach($related as $item)
                <a href="{{ route('services.show', [$locale, $item->getSlug($locale)]) }}"
                   class="group bg-white rounded-xl border border-gray-100 p-5 hover:shadow-md hover:border-blue-100 transition-all duration-300">
                    <h3 class="font-semibold text-gray-900 group-hover:text-blue-700 text-sm transition-colors">
                        {{ $item->getTitle($locale) }}
                    </h3>
                    @if($item->getDescription($locale))
                        <p class="text-gray-500 text-xs mt-1 line-clamp-2">{{ $item->getDescription($locale) }}</p>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
