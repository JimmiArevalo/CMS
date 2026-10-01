@extends('layouts.public')

@section('title', 'Próximos Estrenos de Anime')

@section('content')
    <div style="margin-bottom: 24px;">
        <h1 class="section-title">📅 Próximos Estrenos</h1>
        <p class="muted">Calendario de nuevas temporadas, películas y proyectos anunciados para emisión.</p>
    </div>

    @if ($animes->isEmpty())
        <div class="card empty-state">
            <div class="icon">📅</div>
            <h3>No hay próximos estrenos programados por el momento</h3>
            <p>Revisa nuestro catálogo para descubrir series disponibles.</p>
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
                            <span class="badge" style="background: var(--card2); color: var(--accent); font-size: 10px;">{{ $anime->type }}</span>
                            <span class="status-badge status-proximo">Próximo</span>
                        </div>

                        <h2 class="card-title" style="font-size: 1.05rem;">
                            <a href="{{ route('anime.show', $anime->slug) }}">{{ $anime->title }}</a>
                        </h2>

                        <div style="background: var(--card2); border-radius: 6px; padding: 8px; margin: 8px 0; font-size: 0.85rem;">
                            <div>📅 <strong>Fecha:</strong> {{ $anime->aired_from ? $anime->aired_from->format('d/m/Y') : 'Por confirmar' }}</div>
                            <div>🎞️ <strong>Temporada:</strong> {{ $anime->seasons }}</div>
                            @if ($anime->studio)
                                <div>🏢 <strong>Estudio:</strong> {{ $anime->studio }}</div>
                            @endif
                        </div>

                        <div class="card-genres">
                            @foreach ($anime->genres as $g)
                                <a href="{{ route('genre.show', $g->slug) }}" class="genre-tag">{{ $g->name }}</a>
                            @endforeach
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
@endsection
