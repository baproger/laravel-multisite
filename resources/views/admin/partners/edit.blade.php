@extends('layouts.admin')

@section('page-title', 'Редактировать партнёра')
@section('title', 'Партнёр: ' . $partner->name_ru)

@section('content')

<div class="mb-5">
    <a href="{{ route('admin.partners.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-900 transition-colors">
        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
        </svg>
        Назад к списку
    </a>
</div>

<form method="POST" action="{{ route('admin.partners.update', $partner->id) }}" enctype="multipart/form-data" x-data="{ activeTab: 'ru' }">
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
                            @if($partner->{"name_{$lang}"})<span class="ml-1 w-1.5 h-1.5 bg-green-500 rounded-full inline-block"></span>@endif
                        </button>
                    @endforeach
                </div>
                <div class="p-5">
                    @foreach(['ru', 'kz', 'en'] as $lang)
                        <div x-show="activeTab === '{{ $lang }}'" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Название {{ strtoupper($lang) }} @if($lang === 'ru')<span class="text-red-500">*</span>@endif</label>
                                <input type="text" name="name_{{ $lang }}"
                                       value="{{ old('name_' . $lang, $partner->{"name_{$lang}"}) }}"
                                       {{ $lang === 'ru' ? 'required' : '' }}
                                       class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Описание {{ strtoupper($lang) }}</label>
                                <textarea name="description_{{ $lang }}" rows="3"
                                          class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none resize-none">{{ old('description_' . $lang, $partner->{"description_{$lang}"}) }}</textarea>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="bg-white border border-gray-200 rounded-xl p-5">
                <h3 class="font-semibold text-gray-900 text-sm mb-4">Настройки</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Тип</label>
                        <select name="type" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="partner" {{ $partner->type === 'partner' ? 'selected' : '' }}>Партнёр</option>
                            <option value="client" {{ $partner->type === 'client' ? 'selected' : '' }}>Клиент</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Статус</label>
                        <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="draft" {{ $partner->status === 'draft' ? 'selected' : '' }}>Черновик</option>
                            <option value="published" {{ $partner->status === 'published' ? 'selected' : '' }}>Опубликовано</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Сайт</label>
                        <input type="url" name="website" value="{{ old('website', $partner->website) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                               placeholder="https://...">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Порядок</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $partner->sort_order) }}" min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-gray-100">
                    <label class="block text-xs font-medium text-gray-600 mb-2">Логотип</label>
                    <div x-data="imageUpload('{{ $partner->logo_url }}')" class="border-2 border-dashed border-gray-300 rounded-xl p-4 text-center hover:border-blue-400 transition-colors cursor-pointer"
                         @click="$refs.fileInput.click()">
                        <template x-if="preview">
                            <img :src="preview" class="mx-auto max-h-24 rounded-lg object-contain mb-2">
                        </template>
                        <template x-if="!preview">
                            <p class="text-gray-400 text-xs">Нажмите для загрузки нового логотипа</p>
                        </template>
                        <input type="file" name="logo" accept="image/*" x-ref="fileInput" @change="handleFile($event)" class="hidden">
                    </div>
                </div>

                <div class="flex space-x-2 mt-5 pt-4 border-t border-gray-100">
                    <button type="submit" class="flex-1 py-2.5 bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold rounded-lg transition-colors">Сохранить</button>
                    <a href="{{ route('admin.partners.index') }}" class="px-3 py-2.5 border border-gray-300 text-gray-600 text-sm rounded-lg hover:bg-gray-50 transition-colors">Отмена</a>
                </div>
            </div>

            <div class="bg-white border border-red-100 rounded-xl p-4">
                <h3 class="font-semibold text-gray-900 text-sm mb-3">Опасная зона</h3>
                <form method="POST" action="{{ route('admin.partners.destroy', $partner->id) }}"
                      x-data @submit.prevent="if(confirm('Удалить партнёра?')) $el.submit()">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-full py-2 border border-red-300 text-red-600 text-sm rounded-lg hover:bg-red-50 transition-colors">Удалить партнёра</button>
                </form>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
function imageUpload(existing) {
    return {
        preview: existing || null,
        handleFile(e) { const f = e.target.files[0]; if (f) this.preview = URL.createObjectURL(f); }
    }
}
</script>
@endpush

@endsection
