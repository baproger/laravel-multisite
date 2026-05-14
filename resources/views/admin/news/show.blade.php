@extends('layouts.admin')

@section('page-title', 'Новость')
@section('title', $news->title_ru)

@section('content')

<div class="mb-5 flex items-center justify-between">
    <a href="{{ route('admin.news.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-900 transition-colors">
        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
        </svg>
        Назад к списку
    </a>
    <div class="flex items-center space-x-2">
        @if(!$news->trashed())
            <a href="{{ route('admin.news.preview', $news->id) }}" target="_blank"
               class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                Предпросмотр
            </a>
            <a href="{{ route('admin.news.edit', $news->id) }}"
               class="inline-flex items-center px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-medium rounded-xl transition-colors">
                Редактировать
            </a>
        @endif
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-5">
    <div class="xl:col-span-2 space-y-5">
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            @if($news->image_url)
                <img src="{{ $news->image_url }}" alt="{{ $news->title_ru }}"
                     class="w-full h-48 object-cover">
            @endif
            <div class="p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-2">{{ $news->title_ru }}</h2>
                @if($news->description_ru)
                    <p class="text-gray-600 mb-4">{{ $news->description_ru }}</p>
                @endif
                @if($news->content_ru)
                    <div class="prose prose-sm max-w-none text-gray-700">
                        {!! nl2br(e($news->content_ru)) !!}
                    </div>
                @endif
            </div>
        </div>

        @if($news->title_kz || $news->title_en)
        <div class="bg-white border border-gray-200 rounded-xl p-6">
            <h3 class="font-semibold text-gray-900 text-sm mb-4">Переводы</h3>
            <div class="space-y-3">
                @if($news->title_kz)
                    <div class="flex items-start space-x-3">
                        <span class="text-xs font-medium bg-blue-100 text-blue-700 px-2 py-0.5 rounded mt-0.5">KZ</span>
                        <p class="font-medium text-gray-900 text-sm">{{ $news->title_kz }}</p>
                    </div>
                @endif
                @if($news->title_en)
                    <div class="flex items-start space-x-3">
                        <span class="text-xs font-medium bg-gray-100 text-gray-600 px-2 py-0.5 rounded mt-0.5">EN</span>
                        <p class="font-medium text-gray-900 text-sm">{{ $news->title_en }}</p>
                    </div>
                @endif
            </div>
        </div>
        @endif
    </div>

    <div class="space-y-4">
        <div class="bg-white border border-gray-200 rounded-xl p-5">
            <h3 class="font-semibold text-gray-900 text-sm mb-4">Информация</h3>
            <dl class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <dt class="text-gray-500">Статус</dt>
                    <dd>
                        @if($news->trashed())
                            <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">В корзине</span>
                        @else
                            <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $news->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ $news->status === 'published' ? 'Опубликовано' : 'Черновик' }}
                            </span>
                        @endif
                    </dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">URL (RU)</dt>
                    <dd class="text-gray-900 font-mono text-xs">{{ $news->slug_ru }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Создано</dt>
                    <dd class="text-gray-900">{{ $news->created_at->format('d.m.Y') }}</dd>
                </div>
                @if($news->published_at)
                <div class="flex justify-between">
                    <dt class="text-gray-500">Опубликовано</dt>
                    <dd class="text-gray-900">{{ $news->published_at->format('d.m.Y') }}</dd>
                </div>
                @endif
                @if($news->author)
                <div class="flex justify-between">
                    <dt class="text-gray-500">Автор</dt>
                    <dd class="text-gray-900">{{ $news->author->name }}</dd>
                </div>
                @endif
            </dl>
        </div>
    </div>
</div>

@endsection
