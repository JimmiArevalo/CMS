@extends('layouts.public')

@section('title', 'Animes de ' . $genre->name)

@section('content')
    <div style="margin-bottom: 24px;">
        <div style="margin-bottom: 8px;">
            <a href="{{ route('genre.index') }}" class="muted" style="font-size: 0.85rem;">← Todos los géneros</a>
        </div>
        <h1 class="section-title">Animes del género: <span style="color: var(--accent);">{{ $genre->name }}</span></h1>
        <p class="muted">Listado de series y películas clasificadas bajo {{ $genre->name }}.</p>
    </div>

    <!-- Pestañas de otros géneros -->
    <div style="display: flex; gap: 8px; overflow-x: auto; padding-bottom: 12px; margin-bottom: 24px;">
        @foreach ($genres as $g)
            <a
                href="{{ route('genre.show', $g->slug) }}"
                class="genre-tag"
                style="padding: 6px 14px; font-size: 13px; text-decoration: none; {{ $g->id === $genre->id ? 'background: var(--primary); color: #fff;' : '' }}"
            >
                {{ $g->name }}
            </a>
        @endforeach
    </div>

    @if ($animes->isEmpty())
        <div class="card empty-state">
            <div class="icon">🏷️</div>
            <h3>No hay animes asociados al género {{ $genre->name }} todavía</h3>
            <p>Explora otros géneros o vuelve al catálogo completo.</p>
            <a href="{{ route('genre.index') }}" class="btn btn-primary" style="margin-top: 12px;">Ver todos los géneros</a>
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

        <div class="pagination">
            {{ $animes->links() }}
        </div>
    @endif
@endsection
