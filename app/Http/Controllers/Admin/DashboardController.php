<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anime;
use App\Models\Genre;
use App\Models\Media;
use App\Models\News;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_news'      => News::count(),
            'published_news'  => News::where('published', true)->orWhereIn('status', ['publicado', 'publicada'])->count(),
            'draft_news'      => News::where('published', false)->whereNotIn('status', ['publicado', 'publicada'])->count(),
            'total_animes'    => Anime::count(),
            'airing_animes'   => Anime::where('status', 'En emisión')->count(),
            'finished_animes' => Anime::where('status', 'Finalizado')->count(),
            'upcoming'        => Anime::where('status', 'Próximo')->count(),
            'genres'          => Genre::count(),
            'total_media'     => Media::count(),
        ];

        $recentNews   = News::with(['category', 'anime', 'media'])->latest()->take(5)->get();
        $recentAnimes = Anime::with(['genres', 'media'])->latest()->take(6)->get();

        return view('admin.dashboard', compact('stats', 'recentNews', 'recentAnimes'));
    }
}
