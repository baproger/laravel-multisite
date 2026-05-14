@extends('layouts.app')

@section('title', $page->{"title_{$locale}"} ?: $page->title_ru)
@section('meta_description', $page->{"meta_description_{$locale}"} ?: $page->meta_description_ru)

@section('content')

{{-- Hero --}}
<section class="bg-gradient-to-br from-blue-950 via-blue-900 to-blue-800 text-white py-14 lg:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold">
            {{ $page->{"title_{$locale}"} ?: $page->title_ru }}
        </h1>
        @if($page->{"description_{$locale}"} ?: $page->description_ru)
            <p class="mt-4 text-blue-200 text-lg max-w-2xl mx-auto">
                {{ $page->{"description_{$locale}"} ?: $page->description_ru }}
            </p>
        @endif
    </div>
</section>

{{-- Контент --}}
<section class="py-12 lg:py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        @if($page->image ?? false)
            <img src="{{ asset('storage/' . $page->image) }}" alt="{{ $page->{"title_{$locale}"} ?: $page->title_ru }}"
                 class="w-full rounded-2xl object-cover max-h-80 mb-10 shadow-md">
        @endif

        @php
            $content = $page->{"content_{$locale}"} ?: $page->content_ru;
        @endphp

        @if($content)
            <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                {!! nl2br(e($content)) !!}
            </div>
        @endif
    </div>
</section>

@endsection
