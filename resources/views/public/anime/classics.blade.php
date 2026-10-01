@extends('layouts.public')

@section('title', 'Clásicos del Anime')

@section('content')
    <div style="margin-bottom: 24px;">
        <h1 class="section-title">📜 Clásicos Inolvidables</h1>
        <p class="muted">Las obras maestras y series de culto que marcaron la historia y evolución de la animación japonesa.</p>
    </div>

    @if ($animes->isEmpty())
        <div class="card empty-state">
            <div class="icon">📜</div>
            <h3>No hay clásicos listados en este momento</h3>
            <p>Visita el catálogo general para encontrar todas las series.</p>
            <a href="{{ route('anime.index') }}" class="btn btn-primary" style="margin-top: 12px;">Ver Catálogo</a>
        </div>
    @else
        <div class="cards-grid">
            @foreach ($animes as $anime)
                <article class="card-item">
                    @if ($anime->media)
                        <img src="{{ $anime->media->url }}" alt="{{ $anime->title }}" class="card-img">
                    @else
                        <div class="card-img" style="display: flex; align-items: center; justify-content: center; color: var(--muted); font-size: 0.8rem;">
                            Sin póster
                        </div>
                    @endif

                    <div class="card-body">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                            <span class="badge" style="background: rgba(147, 51, 234, 0.2); color: #c084fc; font-size: 10px;">Año {{ $anime->year ?? 'Clásico' }}</span>
                            <span class="badge" style="background: var(--card2); color: var(--text); font-size: 10px;">{{ $anime->type }}</span>
                        </div>

                        <h2 class="card-title" style="font-size: 1.05rem;">
                            <a href="{{ route('anime.show', $anime->slug) }}">{{ $anime->title }}</a>
                        </h2>

                        @if ($anime->synopsis)
                            <p class="card-excerpt">{{ Str::limit($anime->synopsis, 90) }}</p>
                        @endif

                        <div class="card-genres">
                            @foreach ($anime->genres->take(3) as $g)
                                <a href="{{ route('genre.show', $g->slug) }}" class="genre-tag">{{ $g->name }}</a>
                            @endforeach
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
@endsection
