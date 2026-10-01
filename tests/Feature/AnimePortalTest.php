<?php

namespace Tests\Feature;

use App\Models\Anime;
use App\Models\News;
use App\Models\User;
use Tests\TestCase;

class AnimePortalTest extends TestCase
{
    public function test_home_page_loads_correctly(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('ANIMEVERSE');
    }

    public function test_public_news_page_and_detail_load(): void
    {
        $response = $this->get('/noticias');
        $response->assertStatus(200);

        $news = News::published()->first();
        if ($news) {
            $detailResponse = $this->get('/noticias/'.$news->slug);
            $detailResponse->assertStatus(200);
            $detailResponse->assertSee($news->title);
        }
    }

    public function test_public_anime_sections_load(): void
    {
        $this->get('/animes')->assertStatus(200);
        $this->get('/tendencias')->assertStatus(200);
        $this->get('/proximos-estrenos')->assertStatus(200);
        $this->get('/clasicos')->assertStatus(200);
        $this->get('/finalizados')->assertStatus(200);
        $this->get('/generos')->assertStatus(200);

        $anime = Anime::first();
        if ($anime) {
            $this->get('/animes/'.$anime->slug)->assertStatus(200)->assertSee($anime->title);
        }
    }

    public function test_guest_can_see_login_and_registration(): void
    {
        $loginRes = $this->get('/login');
        $loginRes->assertStatus(200);
        $loginRes->assertSee('Regístrate aquí');

        $registerRes = $this->get('/register');
        $registerRes->assertStatus(200);
        $registerRes->assertSee('Crear cuenta');
    }

    public function test_guest_can_register_new_account(): void
    {
        $uniqueEmail = 'user_'.uniqid().'@animeverse.test';

        $response = $this->post('/register', [
            'name' => 'Otaku Fan',
            'email' => $uniqueEmail,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['email' => $uniqueEmail]);
    }

    public function test_admin_dashboard_is_protected(): void
    {
        $this->get('/admin')->assertRedirect('/login');

        $user = User::first();
        $this->actingAs($user)->get('/admin')->assertStatus(200)->assertSee('Panel de Control');
    }
}
