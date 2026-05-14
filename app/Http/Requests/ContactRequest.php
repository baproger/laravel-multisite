<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:50',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|min:10|max:5000',
        ];
    }

    public function messages(): array
    {
        $locale = app()->getLocale();
        $msgs = [
            'ru' => [
                'name.required'    => 'Введите ваше имя',
                'email.required'   => 'Введите email',
                'email.email'      => 'Введите корректный email',
                'message.required' => 'Введите сообщение',
                'message.min'      => 'Сообщение должно содержать минимум 10 символов',
            ],
            'kz' => [
                'name.required'    => 'Атыңызды енгізіңіз',
                'email.required'   => 'Email енгізіңіз',
                'email.email'      => 'Дұрыс email енгізіңіз',
                'message.required' => 'Хабарлама енгізіңіз',
                'message.min'      => 'Хабарлама кемінде 10 таңбадан тұруы керек',
            ],
            'en' => [
                'name.required'    => 'Please enter your name',
                'email.required'   => 'Please enter your email',
                'email.email'      => 'Please enter a valid email',
                'message.required' => 'Please enter your message',
                'message.min'      => 'Message must be at least 10 characters',
            ],
        ];

        return $msgs[$locale] ?? $msgs['ru'];
    }
}
