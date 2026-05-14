@extends('layouts.admin')

@section('page-title', 'Дашборд')
@section('title', 'Дашборд')

@section('content')

{{-- Карточки статистики --}}
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 mb-6">
    @foreach([
        ['label' => 'Новостей',   'value' => $stats['news'],     'color' => 'blue',   'route' => 'admin.news.index'],
        ['label' => 'Услуг',      'value' => $stats['services'], 'color' => 'indigo', 'route' => 'admin.services.index'],
        ['label' => 'Страниц',    'value' => $stats['pages'],    'color' => 'violet', 'route' => 'admin.pages.index'],
        ['label' => 'Команда',    'value' => $stats['team'],     'color' => 'sky',    'route' => 'admin.team.index'],
        ['label' => 'Партнёров',  'value' => $stats['partners'], 'color' => 'cyan',   'route' => 'admin.partners.index'],
        ['label' => 'FAQ',        'value' => $stats['faq'],      'color' => 'teal',   'route' => 'admin.faq.index'],
        ['label' => 'Сообщений',  'value' => $stats['messages'], 'color' => $stats['messages_new'] > 0 ? 'red' : 'gray', 'route' => 'admin.messages.index', 'badge' => $stats['messages_new']],
    ] as $stat)
        <a href="{{ route($stat['route']) }}"
           class="bg-white border border-gray-200 rounded-xl p-4 hover:shadow-md hover:border-{{ $stat['color'] }}-200 transition-all duration-200 group">
            <p class="text-2xl font-bold text-gray-900 group-hover:text-{{ $stat['color'] }}-700 transition-colors">
                {{ $stat['value'] }}
                @if(isset($stat['badge']) && $stat['badge'] > 0)
                    <span class="text-xs text-red-500 font-normal">(+{{ $stat['badge'] }} новых)</span>
                @endif
            </p>
            <p class="text-gray-500 text-xs mt-0.5">{{ $stat['label'] }}</p>
        </a>
    @endforeach
</div>

{{-- Быстрые действия --}}
<div class="bg-white border border-gray-200 rounded-xl p-5 mb-6">
    <h2 class="text-sm font-semibold text-gray-700 mb-3">Быстрые действия</h2>
    <div class="flex flex-wrap gap-2">
        @foreach([
            ['route' => 'admin.news.create',     'label' => '+ Новость'],
            ['route' => 'admin.services.create', 'label' => '+ Услугу'],
            ['route' => 'admin.pages.create',    'label' => '+ Страницу'],
            ['route' => 'admin.team.create',     'label' => '+ Сотрудника'],
            ['route' => 'admin.partners.create', 'label' => '+ Партнёра'],
            ['route' => 'admin.faq.create',      'label' => '+ FAQ'],
        ] as $action)
            <a href="{{ route($action['route']) }}"
               class="px-4 py-2 bg-gray-100 hover:bg-blue-600 hover:text-white text-gray-700 text-sm font-medium rounded-lg transition-all duration-200">
                {{ $action['label'] }}
            </a>
        @endforeach
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Последние новости --}}
    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
        <div class="flex items-center justify-between px-5 py-3.5 border-b border-gray-100">
            <h2 class="font-semibold text-gray-900 text-sm">Последние новости</h2>
            <a href="{{ route('admin.news.index') }}" class="text-blue-600 hover:text-blue-800 text-xs font-medium">Все →</a>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($latestNews as $item)
                <div class="flex items-center px-5 py-3 hover:bg-gray-50 transition-colors">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $item->title_ru }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $item->created_at->diffForHumans() }}</p>
                    </div>
                    <span class="ml-3 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                        {{ $item->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                        {{ $item->status === 'published' ? 'Опубликовано' : 'Черновик' }}
                    </span>
                    <a href="{{ route('admin.news.edit', $item->id) }}"
                       class="ml-3 text-gray-400 hover:text-blue-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </a>
                </div>
            @empty
                <p class="px-5 py-8 text-center text-gray-400 text-sm">Новостей нет</p>
            @endforelse
        </div>
    </div>

    {{-- Последние сообщения --}}
    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
        <div class="flex items-center justify-between px-5 py-3.5 border-b border-gray-100">
            <h2 class="font-semibold text-gray-900 text-sm">Последние сообщения</h2>
            <a href="{{ route('admin.messages.index') }}" class="text-blue-600 hover:text-blue-800 text-xs font-medium">Все →</a>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($latestMessages as $msg)
                <a href="{{ route('admin.messages.show', $msg->id) }}"
                   class="flex items-start px-5 py-3 hover:bg-gray-50 transition-colors">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mr-3">
                        <span class="text-blue-600 text-xs font-semibold">{{ substr($msg->name, 0, 1) }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $msg->name }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ $msg->subject ?: substr($msg->message, 0, 50) }}</p>
                    </div>
                    <div class="ml-3 flex flex-col items-end flex-shrink-0">
                        <p class="text-xs text-gray-400">{{ $msg->created_at->diffForHumans() }}</p>
                        @if($msg->status === 'new')
                            <span class="mt-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        @endif
                    </div>
                </a>
            @empty
                <p class="px-5 py-8 text-center text-gray-400 text-sm">Сообщений нет</p>
            @endforelse
        </div>
    </div>

</div>

@endsection
