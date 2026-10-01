@extends('layouts.public')

@section('title', 'Catálogo de Animes')

@section('content')
    <div style="margin-bottom: 24px;">
        <h1 class="section-title">Catálogo Completo de Anime</h1>
        <p class="muted">Explora series, películas, OVAs y ONAs disponibles en nuestra base de datos.</p>
    </div>

    <!-- Filtros de búsqueda -->
    <form action="{{ route('anime.index') }}" method="GET" class="filter-bar">
        <input
            type="text"
            name="q"
            value="{{ request('q') }}"
            placeholder="Buscar por título..."
        >

        <select name="genre">
            <option value="">Todos los géneros</option>
            @foreach ($genres as $g)
                <option value="{{ $g->slug }}" {{ request('genre') === $g->slug ? 'selected' : '' }}>
                    {{ $g->name }}
                </option>
            @endforeach
        </select>

        <select name="status">
            <option value="">Todos los estados</option>
            @foreach (['En emisión', 'Finalizado', 'Próximo', 'Pausado', 'Cancelado'] as $st)
                <option value="{{ $st }}" {{ request('status') === $st ? 'selected' : '' }}>
                    {{ $st }}
                </option>
            @endforeach
        </select>

        <select name="type">
            <option value="">Todos los formatos</option>
            @foreach (['Serie', 'Película', 'OVA', 'ONA'] as $tp)
                <option value="{{ $tp }}" {{ request('type') === $tp ? 'selected' : '' }}>
                    {{ $tp }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary btn-sm">Filtrar</button>
        @if (request()->hasAny(['q', 'genre', 'status', 'type']))
            <a href="{{ route('anime.index') }}" class="btn btn-outline btn-sm">Limpiar</a>
        @endif
    </form>

    @if ($animes->isEmpty())
        <div class="card empty-state">
            <div class="icon">🎬</div>
            <h3>No se encontraron animes con los filtros seleccionados</h3>
            <p>Prueba buscando con otros términos o limpiando los filtros.</p>
            <a href="{{ route('anime.index') }}" class="btn btn-primary" style="margin-top: 12px;">Ver todos los animes</a>
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
                                    'Pausado'    => 'status-pausado',
                                    'Cancelado'  => 'status-cancelado',
                                    default      => 'badge-off',
                                };
                            @endphp
                            <span class="status-badge {{ $class }}">{{ $anime->status }}</span>
                        </div>

                        <h2 class="card-title" style="font-size: 1.05rem;">
                            <a href="{{ route('anime.show', $anime->slug) }}">{{ $anime->title }}</a>
                        </h2>

                        <div class="card-genres">
                            @foreach ($anime->genres->take(3) as $g)
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
