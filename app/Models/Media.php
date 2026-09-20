<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    protected $table = 'media';

    protected $fillable = [
        'name',
        'path',
        'mime_type',
        'size',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
            'size' => 'integer',
        ];
    }

    /**
     * URL pública de la imagen: $media->url
     */
    protected function url(): Attribute
    {
        return Attribute::get(
            fn () => Storage::disk('public')->url($this->path)
        );
    }
}