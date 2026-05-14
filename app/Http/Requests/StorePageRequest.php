<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isEditor();
    }

    public function rules(): array
    {
        $id = $this->route('id'); // null при создании
        $uniqueRu = $id ? "unique:pages,slug_ru,{$id}" : 'unique:pages,slug_ru';

        return [
            'title_ru'           => 'required|string|max:255',
            'title_kz'           => 'nullable|string|max:255',
            'title_en'           => 'nullable|string|max:255',
            'slug_ru'            => "required|string|max:255|{$uniqueRu}",
            'slug_kz'            => 'nullable|string|max:255',
            'slug_en'            => 'nullable|string|max:255',
            'description_ru'     => 'nullable|string|max:500',
            'description_kz'     => 'nullable|string|max:500',
            'description_en'     => 'nullable|string|max:500',
            'content_ru'         => 'required|string',
            'content_kz'         => 'nullable|string',
            'content_en'         => 'nullable|string',
            'meta_title_ru'      => 'nullable|string|max:255',
            'meta_title_kz'      => 'nullable|string|max:255',
            'meta_title_en'      => 'nullable|string|max:255',
            'meta_description_ru'=> 'nullable|string|max:500',
            'meta_description_kz'=> 'nullable|string|max:500',
            'meta_description_en'=> 'nullable|string|max:500',
            'image'              => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'status'             => 'required|in:draft,published',
            'sort_order'         => 'nullable|integer|min:0',
            'show_in_menu'       => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'title_ru.required'  => 'Заголовок (RU) обязателен',
            'slug_ru.required'   => 'URL (RU) обязателен',
            'slug_ru.unique'     => 'Этот URL уже занят',
            'content_ru.required'=> 'Содержимое (RU) обязательно',
            'status.required'    => 'Выберите статус',
            'image.image'        => 'Файл должен быть изображением',
            'image.mimes'        => 'Допустимые форматы: jpg, jpeg, png, webp',
            'image.max'          => 'Максимальный размер файла: 5 МБ',
        ];
    }
}
