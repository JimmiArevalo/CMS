<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class RouteDefinitionsTest extends TestCase
{
    public function test_public_and_admin_anime_routes_exist(): void
    {
        $this->assertNotNull(Route::getRoutes()->getByName('anime.index'));
        $this->assertNotNull(Route::getRoutes()->getByName('anime.show'));
        $this->assertNotNull(Route::getRoutes()->getByName('anime.trending'));
        $this->assertNotNull(Route::getRoutes()->getByName('anime.upcoming'));
        $this->assertNotNull(Route::getRoutes()->getByName('anime.classics'));
        $this->assertNotNull(Route::getRoutes()->getByName('anime.finished'));
        $this->assertNotNull(Route::getRoutes()->getByName('genre.index'));
        $this->assertNotNull(Route::getRoutes()->getByName('genre.show'));
        $this->assertNotNull(Route::getRoutes()->getByName('admin.anime.index'));
        $this->assertNotNull(Route::getRoutes()->getByName('admin.genre.index'));
    }
}
