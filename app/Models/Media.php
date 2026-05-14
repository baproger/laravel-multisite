<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Media extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'filename', 'original_name', 'path', 'disk',
        'mime_type', 'size', 'alt_ru', 'alt_kz', 'alt_en',
        'collection', 'mediable_id', 'mediable_type',
        'sort_order', 'uploaded_by',
    ];

    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path);
    }

    public function getAlt(string $locale = 'ru'): string
    {
        return $this->{"alt_{$locale}"} ?: ($this->original_name ?? '');
    }

    public function getSizeFormattedAttribute(): string
    {
        $size = $this->size;
        if ($size < 1024)       return "{$size} B";
        if ($size < 1048576)    return round($size / 1024, 1) . ' KB';
        return round($size / 1048576, 1) . ' MB';
    }

    public function isImage(): bool
    {
        return str_starts_with($this->mime_type, 'image/');
    }
}
