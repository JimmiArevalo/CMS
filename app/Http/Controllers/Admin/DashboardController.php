<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anime;
use App\Models\Genre;
use App\Models\News;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_news'     => News::count(),
            'published_news' => News::where('status', 'publicada')->count(),
            'draft_news'     => News::where('status', 'borrador')->count(),
            'total_animes'   => Anime::count(),
            'upcoming'       => Anime::where('status', 'Próximo')->count(),
            'genres'         => Genre::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
