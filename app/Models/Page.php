<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Page extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title_ru', 'title_kz', 'title_en',
        'slug_ru',  'slug_kz',  'slug_en',
        'description_ru', 'description_kz', 'description_en',
        'content_ru',     'content_kz',     'content_en',
        'meta_title_ru',  'meta_title_kz',  'meta_title_en',
        'meta_description_ru', 'meta_description_kz', 'meta_description_en',
        'image', 'status', 'sort_order', 'show_in_menu', 'created_by',
    ];

    protected $casts = [
        'show_in_menu' => 'boolean',
    ];

    // --- Скоупы ---

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    // --- Геттеры (локализованные поля) ---

    public function getTitle(string $locale = 'ru'): string
    {
        $field = "title_{$locale}";
        return $this->$field ?: ($this->title_ru ?? '');
    }

    public function getSlug(string $locale = 'ru'): string
    {
        $field = "slug_{$locale}";
        return $this->$field ?: ($this->slug_ru ?? '');
    }

    public function getDescription(string $locale = 'ru'): ?string
    {
        $field = "description_{$locale}";
        return $this->$field ?: $this->description_ru;
    }

    public function getContent(string $locale = 'ru'): ?string
    {
        $field = "content_{$locale}";
        return $this->$field ?: $this->content_ru;
    }

    public function getMetaTitle(string $locale = 'ru'): ?string
    {
        $field = "meta_title_{$locale}";
        return $this->$field ?: $this->getTitle($locale);
    }

    public function getMetaDescription(string $locale = 'ru'): ?string
    {
        $field = "meta_description_{$locale}";
        return $this->$field ?: $this->getDescription($locale);
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    // --- Связи ---

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Найти страницу по слагу и локали
    public static function findBySlug(string $slug, string $locale): ?self
    {
        return static::published()
            ->where("slug_{$locale}", $slug)
            ->first();
    }
}
