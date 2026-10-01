<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class News extends Model
{
    protected $table = 'news';

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'media_id',
        'category_id',
        'anime_id',
        'author',
        'status',
        'published',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'published'    => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function scopePublished($query)
    {
        return $query->where('published', true)
            ->whereNotNull('published_at');
    }

    public static function uniqueSlug(string $title): string
    {
        $base = Str::slug($title) ?: 'noticia';
        $slug = $base;
        $i = 2;

        while (static::where('slug', $slug)->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function anime(): BelongsTo
    {
        return $this->belongsTo(Anime::class);
    }
}