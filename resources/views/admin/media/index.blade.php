@extends('layouts.admin')

@section('page-title', 'Медиафайлы')
@section('title', 'Медиа менеджер')

@section('content')

<div class="flex items-center justify-between mb-5">
    <div>
        <h2 class="text-lg font-semibold text-gray-900">Медиафайлы</h2>
        <p class="text-sm text-gray-500 mt-0.5">Загруженные изображения и документы</p>
    </div>
    <label for="upload-files"
           class="inline-flex items-center px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-medium rounded-xl transition-colors shadow-sm cursor-pointer">
        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
        </svg>
        Загрузить файлы
    </label>
</div>

{{-- Форма загрузки --}}
<form method="POST" action="{{ route('admin.media.upload') }}" enctype="multipart/form-data" id="upload-form">
    @csrf
    <input type="file" name="files[]" id="upload-files" multiple accept="image/*,.pdf,.doc,.docx" class="hidden"
           onchange="document.getElementById('upload-form').submit()">
</form>

{{-- Фильтр по типу --}}
<div class="bg-white border border-gray-200 rounded-xl p-4 mb-5">
    <form method="GET" class="flex flex-wrap gap-3">
        <select name="type" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            <option value="">Все типы</option>
            <option value="image" {{ request('type') === 'image' ? 'selected' : '' }}>Изображения</option>
            <option value="application" {{ request('type') === 'application' ? 'selected' : '' }}>Документы</option>
        </select>
        <button type="submit" class="px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors">Фильтровать</button>
        @if(request('type'))
            <a href="{{ route('admin.media.index') }}" class="px-4 py-2 border border-gray-300 text-gray-600 text-sm rounded-lg hover:bg-gray-50 transition-colors">Сбросить</a>
        @endif
    </form>
</div>

{{-- Сетка файлов --}}
@if($files->count())
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
        @foreach($files as $file)
            <div class="group relative bg-white border border-gray-200 rounded-xl overflow-hidden hover:border-blue-300 hover:shadow-md transition-all duration-200">
                {{-- Превью --}}
                <div class="aspect-square bg-gray-50 flex items-center justify-center">
                    @if($file->isImage())
                        <img src="{{ $file->url }}" alt="{{ $file->original_name }}"
                             class="w-full h-full object-cover">
                    @else
                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    @endif
                </div>

                {{-- Информация --}}
                <div class="p-2">
                    <p class="text-xs text-gray-700 font-medium truncate" title="{{ $file->original_name }}">{{ $file->original_name }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $file->size_formatted }}</p>
                </div>

                {{-- Действия (overlay) --}}
                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center space-x-2">
                    <a href="{{ $file->url }}" target="_blank"
                       class="p-2 bg-white/90 text-gray-700 rounded-lg hover:bg-white transition-colors" title="Открыть">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                    </a>
                    <form method="POST" action="{{ route('admin.media.destroy', $file->id) }}"
                          x-data @submit.prevent="if(confirm('Удалить файл?')) $el.submit()">
                        @csrf @method('DELETE')
                        <button type="submit" class="p-2 bg-red-500/90 text-white rounded-lg hover:bg-red-500 transition-colors" title="Удалить">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    @if($files->hasPages())
        <div class="mt-6">{{ $files->links() }}</div>
    @endif
@else
    <div class="bg-white border border-gray-200 rounded-xl py-16 text-center">
        <svg class="mx-auto w-16 h-16 text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        <p class="text-gray-400 font-medium mb-2">Файлы не найдены</p>
        <p class="text-gray-300 text-sm">Загрузите первый файл с помощью кнопки выше</p>
    </div>
@endif

@endsection
