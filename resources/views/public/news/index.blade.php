@extends('layouts.app')

@section('title', $locale === 'kz' ? 'Жаңалықтар' : ($locale === 'en' ? 'News' : 'Новости'))

@section('content')

<section class="bg-gradient-to-br from-blue-900 to-blue-800 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold mb-3">
            @if($locale === 'kz') Жаңалықтар @elseif($locale === 'en') News @else Новости @endif
        </h1>
    </div>
</section>

<section class="py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($news->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($news as $item)
                    <a href="{{ route('news.show', [$locale, $item->getSlug($locale)]) }}"
                       class="group bg-white rounded-2xl overflow-hidden border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        @if($item->image_url)
                            <div class="aspect-video overflow-hidden">
                                <img src="{{ $item->image_url }}" alt="{{ $item->getTitle($locale) }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            </div>
                        @else
                            <div class="aspect-video bg-gradient-to-br from-blue-100 to-blue-200"></div>
                        @endif
                        <div class="p-5">
                            <p class="text-gray-400 text-xs mb-2">
                                {{ $item->published_at ? $item->published_at->format('d.m.Y') : $item->created_at->format('d.m.Y') }}
                            </p>
                            <h2 class="font-semibold text-gray-900 group-hover:text-blue-700 transition-colors duration-200 line-clamp-2 mb-2">
                                {{ $item->getTitle($locale) }}
                            </h2>
                            @if($item->getDescription($locale))
                                <p class="text-gray-500 text-sm line-clamp-2">{{ $item->getDescription($locale) }}</p>
                            @endif
                            <div class="mt-4 text-blue-600 text-sm font-medium flex items-center">
                                @if($locale === 'kz') Толығырақ @elseif($locale === 'en') Read more @else Читать далее @endif
                                <svg class="ml-1 w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- Пагинация --}}
            @if($news->hasPages())
                <div class="mt-10">{{ $news->links() }}</div>
            @endif
        @else
            <div class="text-center py-20">
                <svg class="mx-auto w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
                <p class="text-gray-400 text-lg">
                    @if($locale === 'kz') Жаңалықтар жоқ @elseif($locale === 'en') No news yet @else Новостей пока нет @endif
                </p>
            </div>
        @endif
    </div>
</section>
@endsection
