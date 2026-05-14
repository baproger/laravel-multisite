<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class News extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'news';

    protected $fillable = [
        'title_ru', 'title_kz', 'title_en',
        'slug_ru',  'slug_kz',  'slug_en',
        'description_ru', 'description_kz', 'description_en',
        'content_ru',     'content_kz',     'content_en',
        'meta_title_ru',  'meta_title_kz',  'meta_title_en',
        'meta_description_ru', 'meta_description_kz', 'meta_description_en',
        'image', 'status', 'published_at', 'views', 'created_by',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'views'        => 'integer',
    ];

    // --- Скоупы ---

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                     ->where(function ($q) {
                         $q->whereNull('published_at')
                           ->orWhere('published_at', '<=', now());
                     });
    }

    public function scopeLatest($query)
    {
        return $query->orderByDesc('published_at')->orderByDesc('created_at');
    }

    // --- Локализованные геттеры ---

    public function getTitle(string $locale = 'ru'): string
    {
        return $this->{"title_{$locale}"} ?: ($this->title_ru ?? '');
    }

    public function getSlug(string $locale = 'ru'): string
    {
        return $this->{"slug_{$locale}"} ?: ($this->slug_ru ?? '');
    }

    public function getDescription(string $locale = 'ru'): ?string
    {
        return $this->{"description_{$locale}"} ?: $this->description_ru;
    }

    public function getContent(string $locale = 'ru'): ?string
    {
        return $this->{"content_{$locale}"} ?: $this->content_ru;
    }

    public function getMetaTitle(string $locale = 'ru'): ?string
    {
        return $this->{"meta_title_{$locale}"} ?: $this->getTitle($locale);
    }

    public function getMetaDescription(string $locale = 'ru'): ?string
    {
        return $this->{"meta_description_{$locale}"} ?: $this->getDescription($locale);
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    // Увеличить счётчик просмотров
    public function incrementViews(): void
    {
        $this->increment('views');
    }

    // --- Связи ---

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public static function findBySlug(string $slug, string $locale): ?self
    {
        return static::published()
            ->where("slug_{$locale}", $slug)
            ->first();
    }
}
