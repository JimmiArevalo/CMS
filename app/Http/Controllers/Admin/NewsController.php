<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\News;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        // with('media') carga las imágenes en una sola consulta extra.
        $news = News::with('media')->latest()->get();

        return view('admin.news.index', compact('news'));
    }

    public function create(): View
    {
        return view('admin.news.create', [
            'media' => Media::latest()->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateNews($request);

        News::create([
            'title'     => $validated['title'],
            'slug'      => $this->uniqueSlug($validated['title']),
            'excerpt'   => $validated['excerpt'] ?? null,
            'content'   => $validated['content'],
            'media_id'  => $validated['media_id'] ?? null,
            'published' => $request->boolean('published'),
        ]);

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'Noticia creada correctamente.');
    }

    public function edit(News $news): View
    {
        return view('admin.news.edit', [
            'news'  => $news,
            'media' => Media::latest()->get(),
        ]);
    }

    public function update(Request $request, News $news): RedirectResponse
    {
        $validated = $this->validateNews($request);

        // El slug no cambia al editar, para no romper enlaces existentes.
        $news->update([
            'title'     => $validated['title'],
            'excerpt'   => $validated['excerpt'] ?? null,
            'content'   => $validated['content'],
            'media_id'  => $validated['media_id'] ?? null,
            'published' => $request->boolean('published'),
        ]);

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'Noticia actualizada correctamente.');
    }

    public function destroy(News $news): RedirectResponse
    {
        // Solo se elimina la noticia. La imagen sigue en la biblioteca
        // porque otras noticias podrían estar usándola.
        $news->delete();

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'Noticia eliminada correctamente.');
    }

    private function validateNews(Request $request): array
    {
        return $request->validate([
            'title'     => ['required', 'string', 'max:255'],
            'excerpt'   => ['nullable', 'string', 'max:500'],
            'content'   => ['required', 'string', 'max:20000'],
            'media_id'  => ['nullable', 'integer', 'exists:media,id'],
            'published' => ['nullable', 'boolean'],
        ], [
            'title.required'   => 'El título es obligatorio.',
            'title.max'        => 'El título no puede superar los 255 caracteres.',
            'excerpt.max'      => 'El resumen no puede superar los 500 caracteres.',
            'content.required' => 'El contenido es obligatorio.',
            'content.max'      => 'El contenido no puede superar los 20000 caracteres.',
            'media_id.exists'  => 'La imagen seleccionada no existe.',
            'media_id.integer' => 'La imagen seleccionada no es válida.',
        ]);
    }

    /**
     * Genera un slug único a partir del título (mi-titulo, mi-titulo-2...).
     */
    private function uniqueSlug(string $title): string
    {
        $base = Str::slug($title) ?: 'noticia';
        $slug = $base;
        $i = 2;

        while (News::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}