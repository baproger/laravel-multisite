@extends('layouts.admin')

@section('page-title', 'Настройки')
@section('title', 'Настройки сайта')

@section('content')

<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
    @csrf

    @if(session('success'))
        <div class="mb-5 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @php
        $groupLabels = [
            'general' => 'Основные настройки',
            'contact' => 'Контактная информация',
            'seo'     => 'SEO настройки',
            'social'  => 'Социальные сети',
        ];
    @endphp

    <div class="space-y-6">
        @foreach($settings as $group => $groupSettings)
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <h3 class="font-semibold text-gray-900 text-sm">{{ $groupLabels[$group] ?? ucfirst($group) }}</h3>
            </div>
            <div class="p-6 space-y-5">
                @foreach($groupSettings as $setting)
                    <div>
                        <label for="setting_{{ $setting->key }}" class="block text-sm font-medium text-gray-700 mb-1.5">
                            {{ $setting->label_ru ?: $setting->key }}
                        </label>

                        @if($setting->type === 'textarea')
                            <textarea name="{{ $setting->key }}" id="setting_{{ $setting->key }}" rows="3"
                                      class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none resize-none">{{ $setting->value }}</textarea>

                        @elseif($setting->type === 'image')
                            <div class="flex items-start space-x-4" x-data="imageUpload('{{ $setting->value ? asset('storage/' . $setting->value) : '' }}')">
                                <div class="flex-1">
                                    <input type="file" name="{{ $setting->key }}" id="setting_{{ $setting->key }}"
                                           accept="image/*" @change="handleFile($event)"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                                </div>
                                <template x-if="preview">
                                    <img :src="preview" class="w-16 h-16 rounded-lg object-contain border border-gray-200 bg-gray-50">
                                </template>
                            </div>

                        @elseif($setting->type === 'boolean')
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="{{ $setting->key }}" value="0">
                                <input type="checkbox" name="{{ $setting->key }}" value="1"
                                       {{ $setting->value ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>

                        @else
                            <input type="text" name="{{ $setting->key }}" id="setting_{{ $setting->key }}"
                                   value="{{ $setting->value }}"
                                   class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-6 flex justify-end">
        <button type="submit"
                class="px-8 py-3 bg-blue-700 hover:bg-blue-800 text-white font-semibold rounded-xl transition-colors shadow-sm">
            Сохранить настройки
        </button>
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
