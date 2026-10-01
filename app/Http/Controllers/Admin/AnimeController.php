<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anime;
use App\Models\Genre;
use App\Models\Media;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnimeController extends Controller
{
    public function index(): View
    {
        $animes = Anime::with(['genres', 'media'])->latest()->paginate(20);
        return view('admin.anime.index', compact('animes'));
    }

    public function create(): View
    {
        return view('admin.anime.create', [
            'genres' => Genre::orderBy('name')->get(),
            'media'  => Media::latest()->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateAnime($request);
        $genres = $data['genres'] ?? [];
        unset($data['genres']);

        $data['slug']        = Anime::uniqueSlug($data['title']);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_trending'] = $request->boolean('is_trending');
        $data['is_classic']  = $request->boolean('is_classic');

        $anime = Anime::create($data);
        $anime->genres()->sync($genres);

        return redirect()->route('admin.anime.index')->with('success', 'Anime creado correctamente.');
    }

    public function edit(Anime $anime): View
    {
        return view('admin.anime.edit', [
            'anime'  => $anime->load('genres'),
            'genres' => Genre::orderBy('name')->get(),
            'media'  => Media::latest()->get(),
        ]);
    }

    public function update(Request $request, Anime $anime): RedirectResponse
    {
        $data = $this->validateAnime($request);
        $genres = $data['genres'] ?? [];
        unset($data['genres']);

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_trending'] = $request->boolean('is_trending');
        $data['is_classic']  = $request->boolean('is_classic');

        $anime->update($data);
        $anime->genres()->sync($genres);

        return redirect()->route('admin.anime.index')->with('success', 'Anime actualizado correctamente.');
    }

    public function destroy(Anime $anime): RedirectResponse
    {
        $anime->delete();
        return redirect()->route('admin.anime.index')->with('success', 'Anime eliminado correctamente.');
    }

    private function validateAnime(Request $request): array
    {
        return $request->validate([
            'title'      => ['required', 'string', 'max:255'],
            'title_alt'  => ['nullable', 'string', 'max:255'],
            'synopsis'   => ['nullable', 'string', 'max:5000'],
            'media_id'   => ['nullable', 'integer', 'exists:media,id'],
            'year'       => ['nullable', 'integer', 'min:1900', 'max:2100'],
            'studio'     => ['nullable', 'string', 'max:255'],
            'type'       => ['required', 'in:Serie,Película,OVA,ONA'],
            'status'     => ['required', 'in:En emisión,Finalizado,Próximo,Pausado,Cancelado'],
            'seasons'    => ['nullable', 'integer', 'min:1'],
            'aired_from' => ['nullable', 'date'],
            'aired_to'   => ['nullable', 'date', 'after_or_equal:aired_from'],
            'genres'     => ['nullable', 'array'],
            'genres.*'   => ['exists:genres,id'],
        ]);
    }
}
