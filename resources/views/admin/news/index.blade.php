@extends('layouts.admin')

@section('page-title', 'Новости')
@section('title', 'Управление новостями')

@section('content')

<div class="flex items-center justify-between mb-5">
    <div>
        <h2 class="text-lg font-semibold text-gray-900">Новости</h2>
        <p class="text-sm text-gray-500 mt-0.5">Управление новостями на всех языках</p>
    </div>
    <a href="{{ route('admin.news.create') }}"
       class="inline-flex items-center px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-medium rounded-xl transition-colors shadow-sm">
        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Добавить новость
    </a>
</div>

{{-- Фильтры --}}
<div class="bg-white border border-gray-200 rounded-xl p-4 mb-5">
    <form method="GET" class="flex flex-wrap gap-3">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Поиск по заголовку..."
               class="flex-1 min-w-48 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
        <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            <option value="">Все статусы</option>
            <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Опубликовано</option>
            <option value="draft"     {{ request('status') === 'draft'     ? 'selected' : '' }}>Черновик</option>
            <option value="trash"     {{ request('status') === 'trash'     ? 'selected' : '' }}>Корзина</option>
        </select>
        <button type="submit"
                class="px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors">
            Найти
        </button>
        @if(request()->hasAny(['search', 'status']))
            <a href="{{ route('admin.news.index') }}"
               class="px-4 py-2 border border-gray-300 text-gray-600 text-sm rounded-lg hover:bg-gray-50 transition-colors">
                Сбросить
            </a>
        @endif
    </form>
</div>

{{-- Таблица --}}
<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Заголовок</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-24">Статус</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-28">Языки</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-32">Дата</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider w-32">Действия</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($news as $item)
                    <tr class="{{ $item->trashed() ? 'bg-red-50/50' : 'hover:bg-gray-50' }} transition-colors">
                        <td class="px-4 py-3">
                            <div>
                                <p class="font-medium text-gray-900 line-clamp-1">{{ $item->title_ru }}</p>
                                @if($item->trashed())
                                    <span class="text-xs text-red-500">В корзине</span>
                                @else
                                    <p class="text-xs text-gray-400 mt-0.5 line-clamp-1">{{ $item->slug_ru }}</p>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                {{ $item->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ $item->status === 'published' ? 'Опубликовано' : 'Черновик' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex space-x-1">
                                @foreach(['ru', 'kz', 'en'] as $lang)
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium
                                        {{ $item->{"title_{$lang}"} ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-400' }}">
                                        {{ strtoupper($lang) }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <p class="text-gray-500 text-xs">{{ $item->created_at->format('d.m.Y') }}</p>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end space-x-1">
                                @if($item->trashed())
                                    {{-- Восстановить --}}
                                    <form method="POST" action="{{ route('admin.news.restore', $item->id) }}">
                                        @csrf
                                        <button type="submit" class="p-1.5 text-green-500 hover:bg-green-50 rounded-lg transition-colors" title="Восстановить">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                            </svg>
                                        </button>
                                    </form>
                                @else
                                    {{-- Предпросмотр --}}
                                    <a href="{{ route('admin.news.preview', $item->id) }}" target="_blank"
                                       class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Предпросмотр">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    {{-- Редактировать --}}
                                    <a href="{{ route('admin.news.edit', $item->id) }}"
                                       class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Редактировать">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                @endif
                                {{-- Удалить --}}
                                <form method="POST" action="{{ route('admin.news.destroy', $item->id) }}"
                                      x-data
                                      @submit.prevent="if(confirm('{{ $item->trashed() ? 'Удалить окончательно?' : 'Переместить в корзину?' }}')) $el.submit()">
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
                        <td colspan="5" class="px-4 py-12 text-center text-gray-400">
                            Новостей не найдено
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($news->hasPages())
        <div class="px-4 py-3 border-t border-gray-100">{{ $news->links() }}</div>
    @endif
</div>

@endsection
