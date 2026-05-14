@extends('layouts.admin')

@section('page-title', 'Сообщения')
@section('title', 'Входящие обращения')

@section('content')

<div class="flex items-center justify-between mb-5">
    <div>
        <h2 class="text-lg font-semibold text-gray-900">Обращения</h2>
        <p class="text-sm text-gray-500 mt-0.5">Сообщения от посетителей сайта</p>
    </div>
</div>

<div class="bg-white border border-gray-200 rounded-xl p-4 mb-5">
    <form method="GET" class="flex flex-wrap gap-3">
        <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            <option value="">Все статусы</option>
            <option value="new" {{ request('status') === 'new' ? 'selected' : '' }}>Новые</option>
            <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Прочитанные</option>
            <option value="replied" {{ request('status') === 'replied' ? 'selected' : '' }}>Отвеченные</option>
        </select>
        <button type="submit" class="px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors">Фильтровать</button>
        @if(request('status'))
            <a href="{{ route('admin.messages.index') }}" class="px-4 py-2 border border-gray-300 text-gray-600 text-sm rounded-lg hover:bg-gray-50 transition-colors">Сбросить</a>
        @endif
    </form>
</div>

<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Отправитель</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Тема/Сообщение</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-24">Статус</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-32">Дата</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider w-24">Действия</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($messages as $message)
                    <tr class="{{ $message->status === 'new' ? 'bg-blue-50/30' : 'hover:bg-gray-50' }} transition-colors">
                        <td class="px-4 py-3">
                            <div>
                                <p class="font-medium text-gray-900">{{ $message->name }}</p>
                                <p class="text-xs text-gray-400">{{ $message->email }}</p>
                                @if($message->phone)
                                    <p class="text-xs text-gray-400">{{ $message->phone }}</p>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            @if($message->subject)
                                <p class="font-medium text-gray-900 text-sm mb-0.5">{{ $message->subject }}</p>
                            @endif
                            <p class="text-gray-500 text-xs line-clamp-2">{{ $message->message }}</p>
                        </td>
                        <td class="px-4 py-3">
                            @php
                                $statusClasses = [
                                    'new'     => 'bg-red-100 text-red-700',
                                    'read'    => 'bg-gray-100 text-gray-600',
                                    'replied' => 'bg-green-100 text-green-700',
                                ];
                                $statusLabels = [
                                    'new'     => 'Новое',
                                    'read'    => 'Прочитано',
                                    'replied' => 'Отвечено',
                                ];
                            @endphp
                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium {{ $statusClasses[$message->status] ?? 'bg-gray-100 text-gray-600' }}">
                                {{ $statusLabels[$message->status] ?? $message->status }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <p class="text-gray-500 text-xs">{{ $message->created_at->format('d.m.Y H:i') }}</p>
                            <p class="text-gray-400 text-xs">{{ strtoupper($message->locale) }}</p>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end space-x-1">
                                <a href="{{ route('admin.messages.show', $message->id) }}"
                                   class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Просмотреть">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('admin.messages.destroy', $message->id) }}"
                                      x-data @submit.prevent="if(confirm('Удалить сообщение?')) $el.submit()">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
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
                        <td colspan="5" class="px-4 py-12 text-center text-gray-400">Сообщений нет</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($messages->hasPages())
        <div class="px-4 py-3 border-t border-gray-100">{{ $messages->links() }}</div>
    @endif
</div>

@endsection
