@extends('layouts.public')

@section('title', 'Inicio - Tu Portal de Anime')

@section('content')
    {{-- ══ Noticia Destacada / Hero ════════════════════════ --}}
    @if ($featuredNews)
        <article class="hero">
            @if ($featuredNews->media)
                <img src="{{ $featuredNews->media->url }}" alt="{{ $featuredNews->title }}">
            @else
                <div style="position: absolute; inset: 0; background: linear-gradient(135deg, #1e1e2e, #252538); opacity: 1;"></div>
            @endif

            <div class="hero-body">
                @if ($featuredNews->category)
                    <span class="hero-category">{{ $featuredNews->category->name }}</span>
                @endif
                <h1>{{ $featuredNews->title }}</h1>
                @if ($featuredNews->excerpt)
                    <p>{{ $featuredNews->excerpt }}</p>
                @endif
                <div class="hero-meta">
                    <span>Por {{ $featuredNews->author ?? 'Redacción' }}</span> ·
                    <span>{{ $featuredNews->published_at ? $featuredNews->published_at->format('d/m/Y') : $featuredNews->created_at->format('d/m/Y') }}</span>
                    @if ($featuredNews->anime)
                        · <span>Anime: <strong style="color:var(--accent)">{{ $featuredNews->anime->title }}</strong></span>
                    @endif
                </div>
                <div style="margin-top: 20px; display: flex; gap: 12px; flex-wrap: wrap;">
                    <a href="{{ route('news.show', $featuredNews->slug) }}" class="btn btn-accent">
                        Leer noticia completa →
                    </a>
                    <a href="{{ route('anime.index') }}" class="btn btn-outline">
                        Ver catálogo
                    </a>
                </div>
            </div>
        </article>
    @endif

    {{-- ══ Últimas Noticias ════════════════════════════════ --}}
    <div class="section-header">
        <h2 class="section-title">📰 Últimas Noticias</h2>
        <a href="{{ route('news.index') }}" class="section-link">Ver todas →</a>
    </div>

    @if ($recentNews->isEmpty())
        <p class="muted">No hay noticias recientes.</p>
    @else
        <div class="cards-grid">
            @foreach ($recentNews as $item)
                <article class="card-item">
                    @if ($item->media)
                        <img src="{{ $item->media->url }}" alt="{{ $item->title }}" class="card-img">
                    @else
                        <div class="card-img" style="display:flex;align-items:center;justify-content:center;color:var(--muted);font-size:2rem;">📰</div>
                    @endif

                    <div class="card-body">
                        @if ($item->category)
                            <div class="card-category">{{ $item->category->name }}</div>
                        @endif
                        <h3 class="card-title">
                            <a href="{{ route('news.show', $item->slug) }}">{{ $item->title }}</a>
                        </h3>
                        @if ($item->excerpt)
                            <p class="card-excerpt">{{ Str::limit($item->excerpt, 100) }}</p>
                        @endif
                        <div class="card-meta">
                            {{ $item->published_at ? $item->published_at->format('d M, Y') : $item->created_at->format('d M, Y') }}
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @endif

    {{-- ══ Carrusel: Tendencias de Anime ══════════════════ --}}
    @if ($trending->isNotEmpty())
        <div class="section-header">
            <h2 class="section-title">🔥 Animes en Tendencia</h2>
            <a href="{{ route('anime.trending') }}" class="section-link">Ver más →</a>
        </div>

        <div class="carousel-wrapper">
            <button class="carousel-btn carousel-btn-prev" data-dir="prev" aria-label="Anterior">‹</button>

            <div class="carousel-track-container">
                <div class="carousel-track">
                    @foreach ($trending as $anime)
                        <article class="card-item">
                            @if ($anime->media)
                                <img src="{{ $anime->media->url }}" alt="{{ $anime->title }}" class="card-img">
                            @else
                                <div class="card-img" style="display:flex;align-items:center;justify-content:center;color:var(--muted);font-size:2.5rem;">🎌</div>
                            @endif

                            <div class="card-body">
                                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;">
                                    <span class="badge" style="background:rgba(244,117,33,.15);color:var(--accent);border:1px solid rgba(244,117,33,.3);">{{ $anime->type }}</span>
                                    @php
                                        $class = match($anime->status) {
                                            'En emisión' => 'status-emision',
                                            'Finalizado' => 'status-finalizado',
                                            'Próximo'    => 'status-proximo',
                                            default      => 'status-pausado',
                                        };
                                    @endphp
                                    <span class="status-badge {{ $class }}">{{ $anime->status }}</span>
                                </div>

                                <h3 class="card-title">
                                    <a href="{{ route('anime.show', $anime->slug) }}">{{ $anime->title }}</a>
                                </h3>

                                <div class="card-genres">
                                    @foreach ($anime->genres->take(3) as $g)
                                        <a href="{{ route('genre.show', $g->slug) }}" class="genre-tag">{{ $g->name }}</a>
                                    @endforeach
                                </div>

                                <div class="card-meta">
                                    {{ $anime->year ?? '' }}{{ $anime->studio ? ' · ' . $anime->studio : '' }}
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>

            <button class="carousel-btn carousel-btn-next" data-dir="next" aria-label="Siguiente">›</button>
        </div>
    @endif

    {{-- ══ Próximos Estrenos ═══════════════════════════════ --}}
    @if ($upcoming->isNotEmpty())
        <div class="section-header">
            <h2 class="section-title">📅 Próximos Estrenos</h2>
            <a href="{{ route('anime.upcoming') }}" class="section-link">Ver calendario →</a>
        </div>

        <div class="cards-grid">
            @foreach ($upcoming as $anime)
                <article class="card-item">
                    @if ($anime->media)
                        <img src="{{ $anime->media->url }}" alt="{{ $anime->title }}" class="card-img">
                    @else
                        <div class="card-img" style="display:flex;align-items:center;justify-content:center;color:var(--muted);font-size:2.5rem;">📅</div>
                    @endif

                    <div class="card-body">
                        <div class="card-category">
                            Estreno: {{ $anime->aired_from ? $anime->aired_from->format('d/m/Y') : ($anime->year ?? 'Por confirmar') }}
                        </div>
                        <h3 class="card-title">
                            <a href="{{ route('anime.show', $anime->slug) }}">{{ $anime->title }}</a>
                        </h3>
                        <div class="card-genres">
                            @foreach ($anime->genres->take(2) as $g)
                                <a href="{{ route('genre.show', $g->slug) }}" class="genre-tag">{{ $g->name }}</a>
                            @endforeach
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @endif

    {{-- ══ Géneros Destacados ══════════════════════════════ --}}
    @if ($genres->isNotEmpty())
        <div class="section-header">
            <h2 class="section-title">🏷️ Explora por Género</h2>
            <a href="{{ route('genre.index') }}" class="section-link">Todos los géneros →</a>
        </div>

        <div class="genres-grid">
            @foreach ($genres as $g)
                <a href="{{ route('genre.show', $g->slug) }}" class="genre-card">
                    <span class="genre-name">{{ $g->name }}</span>
                    <span class="genre-count">{{ $g->animes_count }} animes</span>
                </a>
            @endforeach
        </div>
    @endif

    {{-- ══ Carrusel: Clásicos del Anime ═══════════════════ --}}
    @if ($classics->isNotEmpty())
        <div class="section-header">
            <h2 class="section-title">📜 Clásicos del Anime</h2>
            <a href="{{ route('anime.classics') }}" class="section-link">Ver todos →</a>
        </div>

        <div class="carousel-wrapper">
            <button class="carousel-btn carousel-btn-prev" data-dir="prev" aria-label="Anterior">‹</button>

            <div class="carousel-track-container">
                <div class="carousel-track">
                    @foreach ($classics as $anime)
                        <article class="card-item">
                            @if ($anime->media)
                                <img src="{{ $anime->media->url }}" alt="{{ $anime->title }}" class="card-img">
                            @else
                                <div class="card-img" style="display:flex;align-items:center;justify-content:center;color:var(--muted);font-size:2.5rem;">📜</div>
                            @endif

                            <div class="card-body">
                                <div class="card-category">Año {{ $anime->year ?? 'Clásico' }}</div>
                                <h3 class="card-title">
                                    <a href="{{ route('anime.show', $anime->slug) }}">{{ $anime->title }}</a>
                                </h3>
                                @if ($anime->synopsis)
                                    <p class="card-excerpt">{{ Str::limit($anime->synopsis, 80) }}</p>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>

            <button class="carousel-btn carousel-btn-next" data-dir="next" aria-label="Siguiente">›</button>
        </div>
    @endif
@endsection