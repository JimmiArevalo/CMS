<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GenreController extends Controller
{
    public function index(): View
    {
        $genres = Genre::withCount('animes')->orderBy('name')->get();
        return view('admin.genre.index', compact('genres'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(['name' => ['required', 'string', 'max:100', 'unique:genres,name']]);
        Genre::create(['name' => $request->name, 'slug' => Genre::uniqueSlug($request->name)]);
        return back()->with('success', 'Género creado correctamente.');
    }

    public function update(Request $request, Genre $genre): RedirectResponse
    {
        $request->validate(['name' => ['required', 'string', 'max:100', 'unique:genres,name,'.$genre->id]]);
        $genre->update(['name' => $request->name]);
        return back()->with('success', 'Género actualizado correctamente.');
    }

    public function destroy(Genre $genre): RedirectResponse
    {
        $genre->delete();
        return back()->with('success', 'Género eliminado.');
    }
}
