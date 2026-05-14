<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Partner extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name_ru', 'name_kz', 'name_en',
        'description_ru', 'description_kz', 'description_en',
        'logo', 'website', 'type', 'status', 'sort_order',
    ];

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function scopePartners($query)
    {
        return $query->where('type', 'partner');
    }

    public function scopeClients($query)
    {
        return $query->where('type', 'client');
    }

    public function getName(string $locale = 'ru'): string
    {
        return $this->{"name_{$locale}"} ?: ($this->name_ru ?? '');
    }

    public function getDescription(string $locale = 'ru'): ?string
    {
        return $this->{"description_{$locale}"} ?: $this->description_ru;
    }

    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo ? asset('storage/' . $this->logo) : null;
    }
}
