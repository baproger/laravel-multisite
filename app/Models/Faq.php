<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faq extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'faq';

    protected $fillable = [
        'question_ru', 'question_kz', 'question_en',
        'answer_ru',   'answer_kz',   'answer_en',
        'category_ru', 'category_kz', 'category_en',
        'status', 'sort_order',
    ];

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function getQuestion(string $locale = 'ru'): string
    {
        return $this->{"question_{$locale}"} ?: ($this->question_ru ?? '');
    }

    public function getAnswer(string $locale = 'ru'): string
    {
        return $this->{"answer_{$locale}"} ?: ($this->answer_ru ?? '');
    }

    public function getCategory(string $locale = 'ru'): ?string
    {
        return $this->{"category_{$locale}"} ?: $this->category_ru;
    }
}
