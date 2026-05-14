@extends('layouts.admin')

@section('page-title', 'Редактировать сотрудника')
@section('title', 'Сотрудник: ' . $member->name_ru)

@section('content')

<div class="mb-5">
    <a href="{{ route('admin.team.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-900 transition-colors">
        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
        </svg>
        Назад к списку
    </a>
</div>

<form method="POST" action="{{ route('admin.team.update', $member->id) }}" enctype="multipart/form-data" x-data="{ activeTab: 'ru' }">
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
                            @if($member->{"name_{$lang}"})<span class="ml-1 w-1.5 h-1.5 bg-green-500 rounded-full inline-block"></span>@endif
                        </button>
                    @endforeach
                </div>
                <div class="p-5">
                    @foreach(['ru', 'kz', 'en'] as $lang)
                        <div x-show="activeTab === '{{ $lang }}'" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">ФИО {{ strtoupper($lang) }} @if($lang === 'ru')<span class="text-red-500">*</span>@endif</label>
                                <input type="text" name="name_{{ $lang }}"
                                       value="{{ old('name_' . $lang, $member->{"name_{$lang}"}) }}"
                                       {{ $lang === 'ru' ? 'required' : '' }}
                                       class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Должность {{ strtoupper($lang) }}</label>
                                <input type="text" name="position_{{ $lang }}"
                                       value="{{ old('position_' . $lang, $member->{"position_{$lang}"}) }}"
                                       class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Биография {{ strtoupper($lang) }}</label>
                                <textarea name="bio_{{ $lang }}" rows="4"
                                          class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none resize-y">{{ old('bio_' . $lang, $member->{"bio_{$lang}"}) }}</textarea>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl p-5">
                <h3 class="font-semibold text-gray-900 text-sm mb-4">Контакты и соцсети</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Email</label>
                        <input type="email" name="email" value="{{ old('email', $member->email) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Телефон</label>
                        <input type="text" name="phone" value="{{ old('phone', $member->phone) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">LinkedIn</label>
                        <input type="url" name="linkedin" value="{{ old('linkedin', $member->linkedin) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Instagram</label>
                        <input type="url" name="instagram" value="{{ old('instagram', $member->instagram) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="bg-white border border-gray-200 rounded-xl p-5">
                <h3 class="font-semibold text-gray-900 text-sm mb-4">Настройки</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Статус</label>
                        <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="draft" {{ $member->status === 'draft' ? 'selected' : '' }}>Черновик</option>
                            <option value="published" {{ $member->status === 'published' ? 'selected' : '' }}>Опубликовано</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Порядок</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $member->sort_order) }}" min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-gray-100">
                    <label class="block text-xs font-medium text-gray-600 mb-2">Фото</label>
                    <div x-data="imageUpload('{{ $member->photo_url ?? '' }}')" class="border-2 border-dashed border-gray-300 rounded-xl p-4 text-center hover:border-blue-400 transition-colors cursor-pointer"
                         @click="$refs.fileInput.click()">
                        <template x-if="preview">
                            <img :src="preview" class="mx-auto w-24 h-24 rounded-xl object-cover mb-2">
                        </template>
                        <template x-if="!preview">
                            <p class="text-gray-400 text-xs">Нажмите для загрузки нового фото</p>
                        </template>
                        <input type="file" name="photo" accept="image/*" x-ref="fileInput" @change="handleFile($event)" class="hidden">
                    </div>
                </div>

                <div class="flex space-x-2 mt-5 pt-4 border-t border-gray-100">
                    <button type="submit" class="flex-1 py-2.5 bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold rounded-lg transition-colors">Сохранить</button>
                    <a href="{{ route('admin.team.index') }}" class="px-3 py-2.5 border border-gray-300 text-gray-600 text-sm rounded-lg hover:bg-gray-50 transition-colors">Отмена</a>
                </div>
            </div>

            <div class="bg-white border border-red-100 rounded-xl p-4">
                <h3 class="font-semibold text-gray-900 text-sm mb-3">Опасная зона</h3>
                <form method="POST" action="{{ route('admin.team.destroy', $member->id) }}"
                      x-data @submit.prevent="if(confirm('Удалить сотрудника?')) $el.submit()">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-full py-2 border border-red-300 text-red-600 text-sm rounded-lg hover:bg-red-50 transition-colors">Удалить сотрудника</button>
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
