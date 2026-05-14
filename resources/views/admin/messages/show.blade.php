@extends('layouts.admin')

@section('page-title', 'Сообщение')
@section('title', 'Обращение от ' . $message->name)

@section('content')

<div class="mb-5 flex items-center justify-between">
    <a href="{{ route('admin.messages.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-900 transition-colors">
        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
        </svg>
        Назад к списку
    </a>
    <form method="POST" action="{{ route('admin.messages.destroy', $message->id) }}"
          x-data @submit.prevent="if(confirm('Удалить сообщение?')) $el.submit()">
        @csrf @method('DELETE')
        <button type="submit" class="inline-flex items-center px-3 py-2 border border-red-300 text-red-600 text-sm rounded-lg hover:bg-red-50 transition-colors">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
            Удалить
        </button>
    </form>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

    <div class="xl:col-span-2">
        <div class="bg-white border border-gray-200 rounded-xl p-6">
            @if($message->subject)
                <h2 class="text-lg font-semibold text-gray-900 mb-4">{{ $message->subject }}</h2>
            @endif
            <div class="bg-gray-50 rounded-xl p-4 text-gray-700 text-sm leading-relaxed whitespace-pre-wrap">{{ $message->message }}</div>
        </div>
    </div>

    <div class="space-y-4">
        <div class="bg-white border border-gray-200 rounded-xl p-5">
            <h3 class="font-semibold text-gray-900 text-sm mb-4">Отправитель</h3>
            <dl class="space-y-3 text-sm">
                <div>
                    <dt class="text-gray-500 text-xs mb-0.5">Имя</dt>
                    <dd class="font-medium text-gray-900">{{ $message->name }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500 text-xs mb-0.5">Email</dt>
                    <dd>
                        <a href="mailto:{{ $message->email }}" class="text-blue-600 hover:underline">{{ $message->email }}</a>
                    </dd>
                </div>
                @if($message->phone)
                <div>
                    <dt class="text-gray-500 text-xs mb-0.5">Телефон</dt>
                    <dd>
                        <a href="tel:{{ $message->phone }}" class="text-blue-600 hover:underline">{{ $message->phone }}</a>
                    </dd>
                </div>
                @endif
                <div>
                    <dt class="text-gray-500 text-xs mb-0.5">Язык</dt>
                    <dd class="text-gray-900">{{ strtoupper($message->locale) }}</dd>
                </div>
            </dl>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-5">
            <h3 class="font-semibold text-gray-900 text-sm mb-4">Информация</h3>
            <dl class="space-y-3 text-sm">
                <div>
                    <dt class="text-gray-500 text-xs mb-0.5">Статус</dt>
                    <dd>
                        @php
                            $cls = ['new' => 'bg-red-100 text-red-700', 'read' => 'bg-gray-100 text-gray-600', 'replied' => 'bg-green-100 text-green-700'];
                            $lbl = ['new' => 'Новое', 'read' => 'Прочитано', 'replied' => 'Отвечено'];
                        @endphp
                        <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium {{ $cls[$message->status] ?? '' }}">
                            {{ $lbl[$message->status] ?? $message->status }}
                        </span>
                    </dd>
                </div>
                <div>
                    <dt class="text-gray-500 text-xs mb-0.5">Получено</dt>
                    <dd class="text-gray-900">{{ $message->created_at->format('d.m.Y в H:i') }}</dd>
                </div>
                @if($message->ip_address)
                <div>
                    <dt class="text-gray-500 text-xs mb-0.5">IP адрес</dt>
                    <dd class="text-gray-500 font-mono text-xs">{{ $message->ip_address }}</dd>
                </div>
                @endif
            </dl>
        </div>

        <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->subject }}"
           class="flex items-center justify-center w-full py-2.5 bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold rounded-xl transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            Ответить по email
        </a>
    </div>
</div>

@endsection
