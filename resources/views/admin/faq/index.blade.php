@extends('layouts.admin')

@section('page-title', 'FAQ')
@section('title', 'Управление FAQ')

@section('content')

<div class="flex items-center justify-between mb-5">
    <div>
        <h2 class="text-lg font-semibold text-gray-900">FAQ</h2>
        <p class="text-sm text-gray-500 mt-0.5">Часто задаваемые вопросы</p>
    </div>
    <a href="{{ route('admin.faq.create') }}"
       class="inline-flex items-center px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-medium rounded-xl transition-colors shadow-sm">
        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Добавить вопрос
    </a>
</div>

<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Вопрос</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-28">Категория</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-24">Статус</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-16">Порядок</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider w-24">Действия</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($faqs as $faq)
                    <tr class="{{ $faq->trashed() ? 'bg-red-50/50' : 'hover:bg-gray-50' }} transition-colors">
                        <td class="px-4 py-3">
                            <p class="font-medium text-gray-900 line-clamp-1">{{ $faq->question_ru }}</p>
                            @if($faq->trashed())
                                <span class="text-xs text-red-500">В корзине</span>
                            @else
                                <p class="text-xs text-gray-400 mt-0.5 line-clamp-1">{{ Str::limit($faq->answer_ru, 60) }}</p>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-gray-500 text-xs">{{ $faq->category_ru ?: '—' }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                {{ $faq->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ $faq->status === 'published' ? 'Опубликовано' : 'Черновик' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-gray-500 text-xs">{{ $faq->sort_order }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end space-x-1">
                                @if(!$faq->trashed())
                                    <a href="{{ route('admin.faq.edit', $faq->id) }}"
                                       class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Редактировать">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                @endif
                                <form method="POST" action="{{ route('admin.faq.destroy', $faq->id) }}"
                                      x-data @submit.prevent="if(confirm('{{ $faq->trashed() ? 'Удалить окончательно?' : 'Удалить?' }}')) $el.submit()">
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
                        <td colspan="5" class="px-4 py-12 text-center text-gray-400">Вопросов не найдено</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($faqs->hasPages())
        <div class="px-4 py-3 border-t border-gray-100">{{ $faqs->links() }}</div>
    @endif
</div>

@endsection
