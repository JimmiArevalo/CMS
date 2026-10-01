<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anime;
use App\Models\Category;
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
        $news = News::with(['media', 'category'])->latest()->paginate(20);
        return view('admin.news.index', compact('news'));
    }

    public function create(): View
    {
        return view('admin.news.create', [
            'media'      => Media::latest()->get(),
            'categories' => Category::orderBy('name')->get(),
            'animes'     => Anime::orderBy('title')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateNews($request);
        $status    = $validated['status'] ?? 'borrador';

        News::create([
            'title'        => $validated['title'],
            'slug'         => News::uniqueSlug($validated['title']),
            'excerpt'      => $validated['excerpt'] ?? null,
            'content'      => $validated['content'],
            'media_id'     => $validated['media_id'] ?? null,
            'category_id'  => $validated['category_id'] ?? null,
            'anime_id'     => $validated['anime_id'] ?? null,
            'author'       => $validated['author'] ?? auth()->user()->name,
            'status'       => $status,
            'published'    => $status === 'publicada',
            'published_at' => $status === 'publicada' ? now() : null,
        ]);

        return redirect()->route('admin.news.index')->with('success', 'Noticia creada correctamente.');
    }

    public function edit(News $news): View
    {
        return view('admin.news.edit', [
            'news'       => $news,
            'media'      => Media::latest()->get(),
            'categories' => Category::orderBy('name')->get(),
            'animes'     => Anime::orderBy('title')->get(),
        ]);
    }

    public function update(Request $request, News $news): RedirectResponse
    {
        $validated = $this->validateNews($request);
        $status    = $validated['status'] ?? 'borrador';

        $news->update([
            'title'        => $validated['title'],
            'excerpt'      => $validated['excerpt'] ?? null,
            'content'      => $validated['content'],
            'media_id'     => $validated['media_id'] ?? null,
            'category_id'  => $validated['category_id'] ?? null,
            'anime_id'     => $validated['anime_id'] ?? null,
            'author'       => $validated['author'] ?? $news->author,
            'status'       => $status,
            'published'    => $status === 'publicada',
            'published_at' => $status === 'publicada' && ! $news->published_at ? now() : $news->published_at,
        ]);

        return redirect()->route('admin.news.index')->with('success', 'Noticia actualizada correctamente.');
    }

    public function destroy(News $news): RedirectResponse
    {
        $news->delete();
        return redirect()->route('admin.news.index')->with('success', 'Noticia eliminada correctamente.');
    }

    private function validateNews(Request $request): array
    {
        return $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'excerpt'     => ['nullable', 'string', 'max:500'],
            'content'     => ['required', 'string', 'max:20000'],
            'media_id'    => ['nullable', 'integer', 'exists:media,id'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'anime_id'    => ['nullable', 'integer', 'exists:animes,id'],
            'author'      => ['nullable', 'string', 'max:100'],
            'status'      => ['required', 'in:borrador,publicada,archivada'],
        ]);
    }
}