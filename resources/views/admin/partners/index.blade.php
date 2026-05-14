@extends('layouts.admin')

@section('page-title', 'Партнёры')
@section('title', 'Управление партнёрами')

@section('content')

<div class="flex items-center justify-between mb-5">
    <div>
        <h2 class="text-lg font-semibold text-gray-900">Партнёры и клиенты</h2>
        <p class="text-sm text-gray-500 mt-0.5">Управление партнёрами компании</p>
    </div>
    <a href="{{ route('admin.partners.create') }}"
       class="inline-flex items-center px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-medium rounded-xl transition-colors shadow-sm">
        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Добавить партнёра
    </a>
</div>

<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Партнёр</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-24">Тип</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-24">Статус</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-16">Порядок</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider w-24">Действия</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($partners as $partner)
                    <tr class="{{ $partner->trashed() ? 'bg-red-50/50' : 'hover:bg-gray-50' }} transition-colors">
                        <td class="px-4 py-3">
                            <div class="flex items-center space-x-3">
                                @if($partner->logo_url)
                                    <img src="{{ $partner->logo_url }}" alt="{{ $partner->name_ru }}"
                                         class="w-10 h-10 object-contain rounded-lg border border-gray-100 bg-gray-50 p-1">
                                @else
                                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 text-xs font-semibold">
                                        {{ strtoupper(substr($partner->name_ru, 0, 2)) }}
                                    </div>
                                @endif
                                <div>
                                    <p class="font-medium text-gray-900">{{ $partner->name_ru }}</p>
                                    @if($partner->website)
                                        <a href="{{ $partner->website }}" target="_blank" class="text-xs text-blue-500 hover:underline">{{ $partner->website }}</a>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                {{ $partner->type === 'partner' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                                {{ $partner->type === 'partner' ? 'Партнёр' : 'Клиент' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                {{ $partner->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ $partner->status === 'published' ? 'Опубликовано' : 'Черновик' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-gray-500 text-xs">{{ $partner->sort_order }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end space-x-1">
                                @if(!$partner->trashed())
                                    <a href="{{ route('admin.partners.edit', $partner->id) }}"
                                       class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Редактировать">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                @endif
                                <form method="POST" action="{{ route('admin.partners.destroy', $partner->id) }}"
                                      x-data @submit.prevent="if(confirm('Удалить партнёра?')) $el.submit()">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Удалить">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-12 text-center text-gray-400">Партнёры не найдены</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($partners->hasPages())
        <div class="px-4 py-3 border-t border-gray-100">{{ $partners->links() }}</div>
    @endif
</div>

@endsection
