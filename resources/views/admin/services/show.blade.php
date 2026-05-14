@extends('layouts.admin')

@section('page-title', 'Услуга')
@section('title', $service->title_ru)

@section('content')

<div class="mb-5 flex items-center justify-between">
    <a href="{{ route('admin.services.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-900 transition-colors">
        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
        </svg>
        Назад к списку
    </a>
    <div class="flex items-center space-x-2">
        <a href="{{ route('admin.services.edit', $service->id) }}"
           class="inline-flex items-center px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-medium rounded-xl transition-colors">
            Редактировать
        </a>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-5">
    <div class="xl:col-span-2 space-y-5">
        <div class="bg-white border border-gray-200 rounded-xl p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-2">{{ $service->title_ru }}</h2>
            @if($service->description_ru)
                <p class="text-gray-600 mb-4">{{ $service->description_ru }}</p>
            @endif
            @if($service->content_ru)
                <div class="prose prose-sm max-w-none text-gray-700">
                    {!! nl2br(e($service->content_ru)) !!}
                </div>
            @endif
        </div>

        @if($service->title_kz || $service->title_en)
        <div class="bg-white border border-gray-200 rounded-xl p-6">
            <h3 class="font-semibold text-gray-900 text-sm mb-4">Переводы</h3>
            <div class="space-y-3">
                @if($service->title_kz)
                    <div class="flex items-start space-x-3">
                        <span class="text-xs font-medium bg-blue-100 text-blue-700 px-2 py-0.5 rounded mt-0.5">KZ</span>
                        <div>
                            <p class="font-medium text-gray-900 text-sm">{{ $service->title_kz }}</p>
                            @if($service->description_kz)<p class="text-gray-500 text-xs mt-0.5">{{ $service->description_kz }}</p>@endif
                        </div>
                    </div>
                @endif
                @if($service->title_en)
                    <div class="flex items-start space-x-3">
                        <span class="text-xs font-medium bg-gray-100 text-gray-600 px-2 py-0.5 rounded mt-0.5">EN</span>
                        <div>
                            <p class="font-medium text-gray-900 text-sm">{{ $service->title_en }}</p>
                            @if($service->description_en)<p class="text-gray-500 text-xs mt-0.5">{{ $service->description_en }}</p>@endif
                        </div>
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
                        <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $service->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $service->status === 'published' ? 'Опубликовано' : 'Черновик' }}
                        </span>
                    </dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">URL (RU)</dt>
                    <dd class="text-gray-900 font-mono text-xs">{{ $service->slug_ru }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Порядок</dt>
                    <dd class="text-gray-900">{{ $service->sort_order }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Создано</dt>
                    <dd class="text-gray-900">{{ $service->created_at->format('d.m.Y') }}</dd>
                </div>
            </dl>
        </div>

        @if($service->image ?? false)
        <div class="bg-white border border-gray-200 rounded-xl p-5">
            <h3 class="font-semibold text-gray-900 text-sm mb-3">Изображение</h3>
            <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title_ru }}"
                 class="w-full rounded-xl object-cover max-h-48">
        </div>
        @endif
    </div>
</div>

@endsection
