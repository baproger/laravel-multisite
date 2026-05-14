@extends('layouts.app')

@section('title', $news->getMetaTitle($locale))
@section('meta_description', $news->getMetaDescription($locale))

@section('content')

<section class="bg-gradient-to-br from-blue-900 to-blue-800 text-white py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Хлебные крошки --}}
        <nav class="flex items-center space-x-2 text-blue-300 text-sm mb-4">
            <a href="{{ route('home', $locale) }}" class="hover:text-white">@if($locale === 'kz') Басты @elseif($locale === 'en') Home @else Главная @endif</a>
            <span>/</span>
            <a href="{{ route('news', $locale) }}" class="hover:text-white">@if($locale === 'kz') Жаңалықтар @elseif($locale === 'en') News @else Новости @endif</a>
            <span>/</span>
            <span class="text-white line-clamp-1">{{ $news->getTitle($locale) }}</span>
        </nav>
        <h1 class="text-3xl lg:text-4xl font-bold leading-tight">{{ $news->getTitle($locale) }}</h1>
        <div class="flex items-center space-x-4 mt-4 text-blue-300 text-sm">
            <span>{{ $news->published_at ? $news->published_at->format('d.m.Y') : $news->created_at->format('d.m.Y') }}</span>
            @if($news->views)
                <span>•</span>
                <span>{{ $news->views }} @if($locale === 'kz') қаралым @elseif($locale === 'en') views @else просмотров @endif</span>
            @endif
        </div>
    </div>
</section>

<article class="py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        @if($news->image_url)
            <img src="{{ $news->image_url }}" alt="{{ $news->getTitle($locale) }}"
                 class="w-full rounded-2xl shadow-lg mb-8 max-h-96 object-cover">
        @endif

        @if($news->getDescription($locale))
            <p class="text-xl text-gray-600 leading-relaxed border-l-4 border-blue-600 pl-5 mb-8 italic">
                {{ $news->getDescription($locale) }}
            </p>
        @endif

        @php
            $content = $news->getContent($locale);
        @endphp

        @if($content)
            <div class="prose prose-lg prose-blue max-w-none text-gray-700 leading-relaxed">
                {!! nl2br(e($content)) !!}
            </div>
        @else
            <div class="py-10 text-center text-gray-400">
                @if($locale === 'kz') Мазмұн толтырылмаған @elseif($locale === 'en') Content not available in this language @else Контент на данном языке не заполнен @endif
            </div>
        @endif

        {{-- Навигация --}}
        <div class="mt-12 pt-8 border-t border-gray-200 flex items-center justify-between">
            <a href="{{ route('news', $locale) }}"
               class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium transition-colors">
                <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
                </svg>
                @if($locale === 'kz') Жаңалықтарға оралу @elseif($locale === 'en') Back to news @else Все новости @endif
            </a>
        </div>
    </div>
</article>

{{-- Похожие новости --}}
@if($related->count())
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">
            @if($locale === 'kz') Басқа жаңалықтар @elseif($locale === 'en') Other News @else Другие новости @endif
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            @foreach($related as $item)
                <a href="{{ route('news.show', [$locale, $item->getSlug($locale)]) }}"
                   class="group bg-white rounded-xl border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">
                    @if($item->image_url)
                        <img src="{{ $item->image_url }}" alt="{{ $item->getTitle($locale) }}"
                             class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-40 bg-gradient-to-br from-blue-100 to-blue-200"></div>
                    @endif
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-900 group-hover:text-blue-700 text-sm line-clamp-2 transition-colors">
                            {{ $item->getTitle($locale) }}
                        </h3>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
