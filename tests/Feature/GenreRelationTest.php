<?php

namespace Tests\Feature;

use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GenreRelationTest extends TestCase
{
    use RefreshDatabase;

    public function test_genre_can_count_animes(): void
    {
        $genre = Genre::create([
            'name' => 'Acción',
            'slug' => 'accion',
        ]);

        $this->assertNotNull($genre->withCount('animes')->first());
    }
}
