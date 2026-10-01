<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicAnimeController extends Controller
{
    public function index(Request $request): View
    {
        $query = Anime::with(['genres', 'media'])->latest();

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(fn ($b) => $b->where('title', 'like', "%{$q}%")->orWhere('title_alt', 'like', "%{$q}%"));
        }

        if ($request->filled('genre')) {
            $query->whereHas('genres', fn ($b) => $b->where('slug', $request->genre));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $animes = $query->paginate(12)->withQueryString();
        $genres = Genre::orderBy('name')->get();

        return view('public.anime.index', compact('animes', 'genres'));
    }

    public function show(string $slug): View
    {
        $anime = Anime::with(['genres', 'media', 'news' => fn ($q) => $q->published()->with('media')->latest('published_at')->take(4)])
            ->where('slug', $slug)
            ->firstOrFail();

        return view('public.anime.show', compact('anime'));
    }

    public function trending(): View
    {
        $animes = Anime::with(['genres', 'media'])->where('is_trending', true)->latest()->get();
        return view('public.anime.trending', compact('animes'));
    }

    public function upcoming(): View
    {
        $animes = Anime::with(['genres', 'media'])
            ->where('status', 'Próximo')
            ->orderBy('aired_from')
            ->get();
        return view('public.anime.upcoming', compact('animes'));
    }

    public function classics(): View
    {
        $animes = Anime::with(['genres', 'media'])
            ->where('is_classic', true)
            ->orderBy('year')
            ->get();
        return view('public.anime.classics', compact('animes'));
    }

    public function finished(): View
    {
        $animes = Anime::with(['genres', 'media'])->where('status', 'Finalizado')->latest()->get();
        return view('public.anime.finished', compact('animes'));
    }

    public function byGenre(string $slug): View
    {
        $genre  = Genre::where('slug', $slug)->firstOrFail();
        $animes = $genre->animes()->with(['genres', 'media'])->paginate(12);
        $genres = Genre::orderBy('name')->get();
        return view('public.genre.show', compact('genre', 'animes', 'genres'));
    }

    public function genres(): View
    {
        $genres = Genre::withCount('animes')->orderBy('name')->get();
        return view('public.genre.index', compact('genres'));
    }
}
