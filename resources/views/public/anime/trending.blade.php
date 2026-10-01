@extends('layouts.public')

@section('title', 'Animes en Tendencia')

@section('content')
    <div style="margin-bottom: 24px;">
        <h1 class="section-title">🔥 Animes en Tendencia</h1>
        <p class="muted">Los títulos más comentados y populares seleccionados por nuestra redacción.</p>
    </div>

    @if ($animes->isEmpty())
        <div class="card empty-state">
            <div class="icon">🔥</div>
            <h3>No hay animes marcados en tendencia en este momento</h3>
            <p>Vuelve a consultar más adelante o visita el catálogo general.</p>
            <a href="{{ route('anime.index') }}" class="btn btn-primary" style="margin-top: 12px;">Ir al Catálogo</a>
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
                            @php
                                $class = match($anime->status) {
                                    'En emisión' => 'status-emision',
                                    'Finalizado' => 'status-finalizado',
                                    'Próximo'    => 'status-proximo',
                                    default      => 'badge-off',
                                };
                            @endphp
                            <span class="status-badge {{ $class }}">{{ $anime->status }}</span>
                        </div>

                        <h2 class="card-title" style="font-size: 1.05rem;">
                            <a href="{{ route('anime.show', $anime->slug) }}">{{ $anime->title }}</a>
                        </h2>

                        <div class="card-genres">
                            @foreach ($anime->genres as $g)
                                <a href="{{ route('genre.show', $g->slug) }}" class="genre-tag">{{ $g->name }}</a>
                            @endforeach
                        </div>

                        <div class="card-meta">
                            {{ $anime->year ?? '' }} {{ $anime->studio ? '· ' . $anime->studio : '' }}
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
@endsection
