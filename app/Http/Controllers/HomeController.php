<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use App\Models\Genre;
use App\Models\News;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featuredNews = News::published()->with(['media', 'category'])->latest('published_at')->first();
        $recentNews   = News::published()->with(['media', 'category'])->latest('published_at')->skip(1)->take(6)->get();
        $trending     = Anime::with(['genres', 'media'])->where('is_trending', true)->take(6)->get();
        $upcoming     = Anime::with(['genres', 'media'])->where('status', 'Próximo')->orderBy('aired_from')->take(4)->get();
        $genres       = Genre::withCount('animes')->orderBy('name')->take(12)->get();
        $classics     = Anime::with(['genres', 'media'])->where('is_classic', true)->take(4)->get();

        return view('home', compact('featuredNews', 'recentNews', 'trending', 'upcoming', 'genres', 'classics'));
    }
}