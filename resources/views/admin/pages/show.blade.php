@extends('layouts.admin')

@section('page-title', 'Страница')
@section('title', $page->title_ru)

@section('content')

<div class="mb-5 flex items-center justify-between">
    <a href="{{ route('admin.pages.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-900 transition-colors">
        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
        </svg>
        Назад к списку
    </a>
    <a href="{{ route('admin.pages.edit', $page->id) }}"
       class="inline-flex items-center px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-medium rounded-xl transition-colors">
        Редактировать
    </a>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-5">
    <div class="xl:col-span-2 space-y-5">
        <div class="bg-white border border-gray-200 rounded-xl p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-2">{{ $page->title_ru }}</h2>
            @if($page->description_ru)
                <p class="text-gray-600 mb-4">{{ $page->description_ru }}</p>
            @endif
            @if($page->content_ru)
                <div class="prose prose-sm max-w-none text-gray-700">
                    {!! nl2br(e($page->content_ru)) !!}
                </div>
            @endif
        </div>
    </div>

    <div class="space-y-4">
        <div class="bg-white border border-gray-200 rounded-xl p-5">
            <h3 class="font-semibold text-gray-900 text-sm mb-4">Информация</h3>
            <dl class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <dt class="text-gray-500">Статус</dt>
                    <dd>
                        <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $page->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $page->status === 'published' ? 'Опубликовано' : 'Черновик' }}
                        </span>
                    </dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">URL (RU)</dt>
                    <dd class="text-gray-900 font-mono text-xs">{{ $page->slug_ru }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">В меню</dt>
                    <dd class="text-gray-900">{{ $page->show_in_menu ? 'Да' : 'Нет' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Создано</dt>
                    <dd class="text-gray-900">{{ $page->created_at->format('d.m.Y') }}</dd>
                </div>
                @if($page->author)
                <div class="flex justify-between">
                    <dt class="text-gray-500">Автор</dt>
                    <dd class="text-gray-900">{{ $page->author->name }}</dd>
                </div>
                @endif
            </dl>
        </div>
    </div>
</div>

@endsection
