<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TeamMember extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'team';

    protected $fillable = [
        'name_ru', 'name_kz', 'name_en',
        'position_ru', 'position_kz', 'position_en',
        'bio_ru', 'bio_kz', 'bio_en',
        'photo', 'email', 'phone',
        'linkedin', 'instagram', 'facebook',
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

    public function getName(string $locale = 'ru'): string
    {
        return $this->{"name_{$locale}"} ?: ($this->name_ru ?? '');
    }

    public function getPosition(string $locale = 'ru'): ?string
    {
        return $this->{"position_{$locale}"} ?: $this->position_ru;
    }

    public function getBio(string $locale = 'ru'): ?string
    {
        return $this->{"bio_{$locale}"} ?: $this->bio_ru;
    }

    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name_ru) . '&size=200&color=1E40AF&background=EFF6FF';
    }
}
