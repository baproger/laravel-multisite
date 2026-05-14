@extends('layouts.app')

@section('title',
    $locale === 'kz' ? 'Байланыс' : ($locale === 'en' ? 'Contact Us' : 'Контакты')
)

@section('content')

{{-- Hero --}}
<section class="bg-gradient-to-br from-blue-900 to-blue-800 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold mb-3">
            @if($locale === 'kz') Байланыс @elseif($locale === 'en') Contact Us @else Контакты @endif
        </h1>
        <p class="text-blue-200">
            @if($locale === 'kz') Бізбен байланысыңыз, жауап береміз
            @elseif($locale === 'en') Get in touch with us, we'll be happy to help
            @else Свяжитесь с нами, мы рады помочь
            @endif
        </p>
    </div>
</section>

<section class="py-16 lg:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

            {{-- Контактная информация --}}
            <div class="space-y-6">
                <h2 class="text-xl font-bold text-gray-900">
                    @if($locale === 'kz') Деректемелер @elseif($locale === 'en') Our Details @else Наши реквизиты @endif
                </h2>

                @foreach([
                    ['icon' => 'location', 'label_ru' => 'Адрес', 'label_kz' => 'Мекенжай', 'label_en' => 'Address', 'value' => 'г. Алматы, ул. Примерная, 1'],
                    ['icon' => 'phone', 'label_ru' => 'Телефон', 'label_kz' => 'Телефон', 'label_en' => 'Phone', 'value' => '+7 (700) 123-45-67'],
                    ['icon' => 'email', 'label_ru' => 'Email', 'label_kz' => 'Email', 'label_en' => 'Email', 'value' => 'info@company.kz'],
                    ['icon' => 'time', 'label_ru' => 'Режим работы', 'label_kz' => 'Жұмыс уақыты', 'label_en' => 'Working hours', 'value' => 'Пн–Пт: 9:00–18:00'],
                ] as $contact)
                    <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-xl">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            @if($contact['icon'] === 'location')
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            @elseif($contact['icon'] === 'phone')
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            @elseif($contact['icon'] === 'email')
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            @else
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            @endif
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 mb-0.5">{{ $contact['label_' . $locale] ?? $contact['label_ru'] }}</p>
                            <p class="text-gray-900 font-medium text-sm">{{ $contact['value'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Форма обратной связи --}}
            <div class="lg:col-span-2">
                <div class="bg-white border border-gray-200 rounded-2xl p-6 sm:p-8 shadow-sm">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">
                        @if($locale === 'kz') Хабарлама жіберу @elseif($locale === 'en') Send a Message @else Отправить сообщение @endif
                    </h2>

                    @if($errors->any())
                        <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-xl">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach($errors->all() as $error)
                                    <li class="text-red-600 text-sm">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contacts.store', $locale) }}" class="space-y-5">
                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    @if($locale === 'kz') Аты * @elseif($locale === 'en') Name * @else Имя * @endif
                                </label>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 @error('name') border-red-400 bg-red-50 @enderror"
                                       placeholder="@if($locale === 'kz') Атыңыз @elseif($locale === 'en') Your name @else Ваше имя @endif">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    @if($locale === 'kz') Email * @elseif($locale === 'en') Email * @else Email * @endif
                                </label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 @error('email') border-red-400 bg-red-50 @enderror"
                                       placeholder="example@email.com">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    @if($locale === 'kz') Телефон @elseif($locale === 'en') Phone @else Телефон @endif
                                </label>
                                <input type="tel" name="phone" value="{{ old('phone') }}"
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
                                       placeholder="+7 (___) ___-__-__">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    @if($locale === 'kz') Тақырып @elseif($locale === 'en') Subject @else Тема @endif
                                </label>
                                <input type="text" name="subject" value="{{ old('subject') }}"
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
                                       placeholder="@if($locale === 'kz') Сұрақтың тақырыбы @elseif($locale === 'en') Subject of inquiry @else Тема вопроса @endif">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                @if($locale === 'kz') Хабарлама * @elseif($locale === 'en') Message * @else Сообщение * @endif
                            </label>
                            <textarea name="message" rows="5" required
                                      class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all resize-none @error('message') border-red-400 bg-red-50 @enderror"
                                      placeholder="@if($locale === 'kz') Хабарламаңызды жазыңыз @elseif($locale === 'en') Write your message @else Ваше сообщение @endif">{{ old('message') }}</textarea>
                        </div>

                        <button type="submit"
                                class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3 bg-blue-700 hover:bg-blue-800 text-white font-semibold rounded-xl transition-all duration-200 shadow-md hover:shadow-lg hover:-translate-y-0.5">
                            @if($locale === 'kz') Жіберу @elseif($locale === 'en') Send Message @else Отправить @endif
                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
