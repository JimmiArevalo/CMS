@extends('layouts.public')

@section('title', 'Géneros de Anime')

@section('content')
    <div style="margin-bottom: 24px;">
        <h1 class="section-title">🏷️ Géneros y Categorías</h1>
        <p class="muted">Encuentra animes según tus temáticas preferidas: Acción, Shonen, Isekai, Romance y más.</p>
    </div>

    @if ($genres->isEmpty())
        <div class="card empty-state">
            <div class="icon">🏷️</div>
            <h3>No hay géneros registrados todavía</h3>
            <p>Vuelve más tarde o explora el catálogo general.</p>
            <a href="{{ route('anime.index') }}" class="btn btn-primary" style="margin-top: 12px;">Ir al Catálogo</a>
        </div>
    @else
        <div class="genres-grid" style="grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));">
            @foreach ($genres as $genre)
                <a href="{{ route('genre.show', $genre->slug) }}" class="genre-card" style="padding: 24px 16px;">
                    <span class="genre-name" style="font-size: 1.1rem;">{{ $genre->name }}</span>
                    <span class="genre-count" style="font-size: 0.85rem; margin-top: 6px; display: block;">
                        {{ $genre->animes_count }} {{ $genre->animes_count == 1 ? 'anime' : 'animes' }}
                    </span>
                </a>
            @endforeach
        </div>
    @endif
@endsection
