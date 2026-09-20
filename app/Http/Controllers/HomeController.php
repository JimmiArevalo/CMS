<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        // Solo noticias publicadas; los borradores no salen al público.
        $news = News::with('media')
            ->where('published', true)
            ->latest()
            ->get();

        return view('home', compact('news'));
    }
}