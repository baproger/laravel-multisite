@extends('layouts.admin')

@section('page-title', 'Добавить услугу')
@section('title', 'Новая услуга')

@section('content')

<div class="mb-5">
    <a href="{{ route('admin.services.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-900 transition-colors">
        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
        </svg>
        Назад к списку
    </a>
</div>

<form method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data" x-data="{ activeTab: 'ru' }">
    @csrf

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
                            {{ $label }} @if($lang === 'ru')<span class="text-red-500 ml-0.5">*</span>@endif
                        </button>
                    @endforeach
                </div>
                <div class="p-5">
                    @foreach(['ru', 'kz', 'en'] as $lang)
                        <div x-show="activeTab === '{{ $lang }}'" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Заголовок {{ strtoupper($lang) }} @if($lang === 'ru')<span class="text-red-500">*</span>@endif</label>
                                <input type="text" name="title_{{ $lang }}" value="{{ old('title_' . $lang) }}"
                                       {{ $lang === 'ru' ? 'required' : '' }}
                                       class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">URL (slug) {{ strtoupper($lang) }} @if($lang === 'ru')<span class="text-red-500">*</span>@endif</label>
                                <div class="flex">
                                    <span class="inline-flex items-center px-3 py-2.5 border border-r-0 border-gray-300 bg-gray-50 text-gray-400 text-xs rounded-l-xl">/{{ $lang }}/services/</span>
                                    <input type="text" name="slug_{{ $lang }}" value="{{ old('slug_' . $lang) }}"
                                           {{ $lang === 'ru' ? 'required' : '' }}
                                           class="flex-1 px-3.5 py-2.5 border border-gray-300 rounded-r-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                                           placeholder="service-slug">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Краткое описание {{ strtoupper($lang) }}</label>
                                <textarea name="description_{{ $lang }}" rows="2"
                                          class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none resize-none">{{ old('description_' . $lang) }}</textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Содержимое {{ strtoupper($lang) }} @if($lang === 'ru')<span class="text-red-500">*</span>@endif</label>
                                <textarea name="content_{{ $lang }}" rows="10"
                                          {{ $lang === 'ru' ? 'required' : '' }}
                                          class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none resize-y">{{ old('content_' . $lang) }}</textarea>
                            </div>
                            <details class="border border-gray-200 rounded-xl">
                                <summary class="px-4 py-3 text-sm font-medium text-gray-700 cursor-pointer hover:bg-gray-50 rounded-xl">SEO ({{ strtoupper($lang) }})</summary>
                                <div class="px-4 pb-4 pt-3 space-y-3 border-t border-gray-100">
                                    <input type="text" name="meta_title_{{ $lang }}" value="{{ old('meta_title_' . $lang) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-1 focus:ring-blue-500 outline-none" placeholder="Meta Title...">
                                    <textarea name="meta_description_{{ $lang }}" rows="2"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-1 focus:ring-blue-500 outline-none resize-none"
                                              placeholder="Meta Description...">{{ old('meta_description_' . $lang) }}</textarea>
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
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Статус <span class="text-red-500">*</span></label>
                        <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="draft" {{ old('status') !== 'published' ? 'selected' : '' }}>Черновик</option>
                            <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Опубликовать</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Порядок</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Иконка (CSS класс)</label>
                        <input type="text" name="icon" value="{{ old('icon') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                               placeholder="fa-star, bi-gear...">
                    </div>
                </div>
                <div class="flex space-x-2 mt-5 pt-4 border-t border-gray-100">
                    <button type="submit" class="flex-1 py-2.5 bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold rounded-lg transition-colors">Сохранить</button>
                    <a href="{{ route('admin.services.index') }}" class="px-3 py-2.5 border border-gray-300 text-gray-600 text-sm rounded-lg hover:bg-gray-50 transition-colors">Отмена</a>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl p-5" x-data="imageUpload()">
                <h3 class="font-semibold text-gray-900 text-sm mb-4">Изображение</h3>
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-4 text-center hover:border-blue-400 transition-colors cursor-pointer"
                     @click="$refs.fileInput.click()">
                    <template x-if="preview">
                        <img :src="preview" class="mx-auto max-h-40 rounded-lg object-cover mb-2">
                    </template>
                    <template x-if="!preview">
                        <div>
                            <svg class="mx-auto w-10 h-10 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-gray-400 text-xs">JPG, PNG, WebP — до 5МБ</p>
                        </div>
                    </template>
                    <input type="file" name="image" accept="image/*" x-ref="fileInput" @change="handleFile($event)" class="hidden">
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
function imageUpload() {
    return {
        preview: null,
        handleFile(e) { const f = e.target.files[0]; if (f) this.preview = URL.createObjectURL(f); }
    }
}
</script>
@endpush

@endsection
