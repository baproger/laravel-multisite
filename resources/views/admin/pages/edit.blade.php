@extends('layouts.admin')

@section('page-title', 'Редактировать страницу')
@section('title', 'Страница: ' . $page->title_ru)

@section('content')

<div class="mb-5 flex items-center justify-between">
    <a href="{{ route('admin.pages.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-900 transition-colors">
        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
        </svg>
        Назад к списку
    </a>
    <a href="{{ route('admin.pages.preview', $page->id) }}" target="_blank"
       class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 transition-colors">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
        </svg>
        Предпросмотр
    </a>
</div>

<form method="POST" action="{{ route('admin.pages.update', $page->id) }}" enctype="multipart/form-data" x-data="{ activeTab: 'ru' }">
    @csrf @method('PUT')

    @if($errors->any())
        <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-xl">
            @foreach($errors->all() as $error)<p class="text-red-600 text-sm">• {{ $error }}</p>@endforeach
        </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

        <div class="xl:col-span-2 space-y-5">
            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                <div class="flex border-b border-gray-200">
                    @foreach(['ru' => '🇷🇺 Русский', 'kz' => '🇰🇿 Қазақша', 'en' => '🇬🇧 English'] as $lang => $label)
                        <button type="button" @click="activeTab = '{{ $lang }}'"
                                :class="activeTab === '{{ $lang }}' ? 'border-b-2 border-blue-600 text-blue-700 bg-blue-50/50' : 'text-gray-500 hover:text-gray-700'"
                                class="flex-1 px-4 py-3 text-sm font-medium transition-all">
                            {{ $label }}
                            @if($page->{"title_{$lang}"})<span class="ml-1 w-1.5 h-1.5 bg-green-500 rounded-full inline-block"></span>@endif
                        </button>
                    @endforeach
                </div>
                <div class="p-5">
                    @foreach(['ru', 'kz', 'en'] as $lang)
                        <div x-show="activeTab === '{{ $lang }}'" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Заголовок {{ strtoupper($lang) }} @if($lang === 'ru')<span class="text-red-500">*</span>@endif</label>
                                <input type="text" name="title_{{ $lang }}"
                                       value="{{ old('title_' . $lang, $page->{"title_{$lang}"}) }}"
                                       {{ $lang === 'ru' ? 'required' : '' }}
                                       class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">URL (slug) {{ strtoupper($lang) }} @if($lang === 'ru')<span class="text-red-500">*</span>@endif</label>
                                <div class="flex">
                                    <span class="inline-flex items-center px-3 py-2.5 border border-r-0 border-gray-300 bg-gray-50 text-gray-400 text-xs rounded-l-xl">/{{ $lang }}/</span>
                                    <input type="text" name="slug_{{ $lang }}"
                                           value="{{ old('slug_' . $lang, $page->{"slug_{$lang}"}) }}"
                                           {{ $lang === 'ru' ? 'required' : '' }}
                                           class="flex-1 px-3.5 py-2.5 border border-gray-300 rounded-r-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Краткое описание {{ strtoupper($lang) }}</label>
                                <textarea name="description_{{ $lang }}" rows="2"
                                          class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none resize-none">{{ old('description_' . $lang, $page->{"description_{$lang}"}) }}</textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Содержимое {{ strtoupper($lang) }} @if($lang === 'ru')<span class="text-red-500">*</span>@endif</label>
                                <textarea name="content_{{ $lang }}" rows="12"
                                          {{ $lang === 'ru' ? 'required' : '' }}
                                          class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none resize-y">{{ old('content_' . $lang, $page->{"content_{$lang}"}) }}</textarea>
                            </div>
                            <details class="border border-gray-200 rounded-xl">
                                <summary class="px-4 py-3 text-sm font-medium text-gray-700 cursor-pointer hover:bg-gray-50 rounded-xl">SEO ({{ strtoupper($lang) }})</summary>
                                <div class="px-4 pb-4 pt-3 space-y-3 border-t border-gray-100">
                                    <input type="text" name="meta_title_{{ $lang }}"
                                           value="{{ old('meta_title_'.$lang, $page->{"meta_title_{$lang}"}) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-1 focus:ring-blue-500 outline-none" placeholder="Meta Title...">
                                    <textarea name="meta_description_{{ $lang }}" rows="2"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-1 focus:ring-blue-500 outline-none resize-none"
                                              placeholder="Meta Description...">{{ old('meta_description_'.$lang, $page->{"meta_description_{$lang}"}) }}</textarea>
                                </div>
                            </details>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="bg-white border border-gray-200 rounded-xl p-5">
                <h3 class="font-semibold text-gray-900 text-sm mb-4">Публикация</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Статус</label>
                        <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="draft" {{ $page->status === 'draft' ? 'selected' : '' }}>Черновик</option>
                            <option value="published" {{ $page->status === 'published' ? 'selected' : '' }}>Опубликовано</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Порядок</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $page->sort_order) }}" min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" name="show_in_menu" id="show_in_menu" value="1"
                               {{ $page->show_in_menu ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="show_in_menu" class="text-sm text-gray-700">Показать в меню</label>
                    </div>
                </div>
                <div class="flex space-x-2 mt-5 pt-4 border-t border-gray-100">
                    <button type="submit" class="flex-1 py-2.5 bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold rounded-lg transition-colors">Сохранить</button>
                    <a href="{{ route('admin.pages.index') }}" class="px-3 py-2.5 border border-gray-300 text-gray-600 text-sm rounded-lg hover:bg-gray-50 transition-colors">Отмена</a>
                </div>
            </div>

            <div class="bg-white border border-red-100 rounded-xl p-4">
                <h3 class="font-semibold text-gray-900 text-sm mb-3">Опасная зона</h3>
                <form method="POST" action="{{ route('admin.pages.destroy', $page->id) }}"
                      x-data @submit.prevent="if(confirm('Переместить в корзину?')) $el.submit()">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-full py-2 border border-red-300 text-red-600 text-sm rounded-lg hover:bg-red-50 transition-colors">Удалить страницу</button>
                </form>
            </div>
        </div>
    </div>
</form>

@endsection
