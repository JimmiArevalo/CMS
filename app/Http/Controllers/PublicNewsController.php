<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicNewsController extends Controller
{
    public function index(Request $request): View
    {
        $query = News::published()->with(['media', 'category'])->latest('published_at');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($builder) use ($q) {
                $builder->where('title', 'like', "%{$q}%")
                    ->orWhere('excerpt', 'like', "%{$q}%");
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('category', fn ($b) => $b->where('slug', $request->category));
        }

        $news       = $query->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('public.news.index', compact('news', 'categories'));
    }

    public function show(string $slug): View
    {
        $item    = News::published()->with(['media', 'category', 'anime'])->where('slug', $slug)->firstOrFail();
        $related = News::published()->with('media')
            ->where('id', '!=', $item->id)
            ->where('category_id', $item->category_id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('public.news.show', compact('item', 'related'));
    }
}
