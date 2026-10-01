@extends('layouts.public')

@section('title', 'Noticias de Anime')

@section('content')
    <div style="margin-bottom: 24px;">
        <h1 class="section-title">Noticias y Actualidad</h1>
        <p class="muted">Últimas novedades, anuncios oficiales, mangas y estrenos del mundo del anime.</p>
    </div>

    <!-- Barra de Búsqueda y Filtros -->
    <form action="{{ route('news.index') }}" method="GET" class="filter-bar">
        <input
            type="text"
            name="q"
            value="{{ request('q') }}"
            placeholder="Buscar noticias por título o contenido..."
        >

        <select name="category">
            <option value="">Todas las categorías</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary btn-sm">Filtrar</button>
        @if (request()->hasAny(['q', 'category']))
            <a href="{{ route('news.index') }}" class="btn btn-outline btn-sm">Limpiar</a>
        @endif
    </form>

    @if ($news->isEmpty())
        <div class="card empty-state">
            <div class="icon">🔍</div>
            <h3>No se encontraron noticias</h3>
            <p>Intenta con otros términos de búsqueda o revisa más tarde.</p>
            <a href="{{ route('news.index') }}" class="btn btn-primary" style="margin-top: 12px;">Ver todas las noticias</a>
        </div>
    @else
        <div class="cards-grid">
            @foreach ($news as $item)
                <article class="card-item">
                    @if ($item->media)
                        <img src="{{ $item->media->url }}" alt="{{ $item->title }}" class="card-img">
                    @else
                        <div class="card-img" style="display: flex; align-items: center; justify-content: center; color: var(--muted); font-size: 0.8rem;">
                            Sin imagen
                        </div>
                    @endif

                    <div class="card-body">
                        @if ($item->category)
                            <div class="card-category">{{ $item->category->name }}</div>
                        @endif
                        <h2 class="card-title" style="font-size: 1.05rem;">
                            <a href="{{ route('news.show', $item->slug) }}">{{ $item->title }}</a>
                        </h2>
                        @if ($item->excerpt)
                            <p class="card-excerpt">{{ Str::limit($item->excerpt, 110) }}</p>
                        @endif
                        <div class="card-meta">
                            <span>Por {{ $item->author ?? 'Redacción' }}</span> ·
                            <span>{{ $item->published_at ? $item->published_at->format('d/m/Y') : $item->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="pagination">
            {{ $news->links() }}
        </div>
    @endif
@endsection
