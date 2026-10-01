<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Anime extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'title_alt',
        'synopsis',
        'media_id',
        'year',
        'studio',
        'type',
        'status',
        'seasons',
        'aired_from',
        'aired_to',
        'is_featured',
        'is_trending',
        'is_classic',
    ];

    protected function casts(): array
    {
        return [
            'aired_from'  => 'date',
            'aired_to'    => 'date',
            'is_featured' => 'boolean',
            'is_trending' => 'boolean',
            'is_classic'  => 'boolean',
            'seasons'     => 'integer',
            'year'        => 'integer',
        ];
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }

    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }

    /**
     * Genera slug único: mi-anime, mi-anime-2, ...
     */
    public static function uniqueSlug(string $title): string
    {
        $base = Str::slug($title) ?: 'anime';
        $slug = $base;
        $i    = 2;

        while (static::where('slug', $slug)->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }
}
