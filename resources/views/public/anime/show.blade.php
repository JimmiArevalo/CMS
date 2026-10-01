@extends('layouts.public')

@section('title', $anime->title)

@section('content')
    <div style="margin-bottom: 20px;">
        <a href="{{ route('anime.index') }}" class="muted" style="font-size: 0.85rem;">← Volver al catálogo</a>
    </div>

    <div class="anime-detail">
        <!-- Póster -->
        <div class="anime-poster">
            @if ($anime->media)
                <img src="{{ $anime->media->url }}" alt="{{ $anime->title }}">
            @else
                <div style="background: var(--card2); border-radius: var(--radius); height: 380px; display: flex; align-items: center; justify-content: center; color: var(--muted);">
                    Sin póster disponible
                </div>
            @endif

            <div style="margin-top: 16px;">
                @if ($anime->is_featured)
                    <span class="badge badge-on" style="display: block; text-align: center; margin-bottom: 6px;">⭐ Destacado</span>
                @endif
                @if ($anime->is_trending)
                    <span class="badge" style="background: rgba(245, 158, 11, 0.2); color: var(--accent); display: block; text-align: center; margin-bottom: 6px;">🔥 En Tendencia</span>
                @endif
                @if ($anime->is_classic)
                    <span class="badge" style="background: rgba(147, 51, 234, 0.2); color: #c084fc; display: block; text-align: center;">📜 Clásico</span>
                @endif
            </div>
        </div>

        <!-- Información -->
        <div class="anime-info">
            <h1>{{ $anime->title }}</h1>
            @if ($anime->title_alt)
                <div class="title-alt">{{ $anime->title_alt }}</div>
            @endif

            <!-- Géneros -->
            <div style="display: flex; flex-wrap: wrap; gap: 6px; margin: 12px 0 20px;">
                @foreach ($anime->genres as $genre)
                    <a href="{{ route('genre.show', $genre->slug) }}" class="genre-tag" style="font-size: 13px; padding: 4px 12px;">
                        {{ $genre->name }}
                    </a>
                @endforeach
            </div>

            <!-- Ficha Técnica -->
            <div class="card" style="background: var(--card); border: 1px solid var(--border); border-radius: var(--radius); padding: 18px; margin-bottom: 24px;">
                <div class="info-grid">
                    <div class="info-item">
                        <label>Tipo / Formato</label>
                        <span>{{ $anime->type }}</span>
                    </div>
                    <div class="info-item">
                        <label>Estado</label>
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
                    <div class="info-item">
                        <label>Año de estreno</label>
                        <span>{{ $anime->year ?? 'No especificado' }}</span>
                    </div>
                    <div class="info-item">
                        <label>Estudio</label>
                        <span>{{ $anime->studio ?? 'No especificado' }}</span>
                    </div>
                    <div class="info-item">
                        <label>Temporadas</label>
                        <span>{{ $anime->seasons }}</span>
                    </div>
                    <div class="info-item">
                        <label>Fecha de estreno</label>
                        <span>{{ $anime->aired_from ? $anime->aired_from->format('d/m/Y') : 'Por confirmar' }}</span>
                    </div>
                    @if ($anime->aired_to)
                        <div class="info-item">
                            <label>Fecha de finalización</label>
                            <span>{{ $anime->aired_to->format('d/m/Y') }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sinopsis -->
            <div>
                <h3 style="font-size: 1.1rem; color: var(--accent); margin-bottom: 8px;">Sinopsis</h3>
                <div style="line-height: 1.7; color: var(--text); font-size: 1rem;">
                    @if ($anime->synopsis)
                        {!! nl2br(e($anime->synopsis)) !!}
                    @else
                        <p class="muted">No hay sinopsis disponible para este anime.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Noticias relacionadas con este anime -->
    @if ($anime->news->isNotEmpty())
        <div style="margin-top: 48px; padding-top: 32px; border-top: 1px solid var(--border);">
            <h2 class="section-title">Noticias sobre {{ $anime->title }}</h2>

            <div class="cards-grid">
                @foreach ($anime->news as $item)
                    <article class="card-item">
                        @if ($item->media)
                            <img src="{{ $item->media->url }}" alt="{{ $item->title }}" class="card-img" style="height: 150px;">
                        @endif
                        <div class="card-body">
                            <h3 class="card-title" style="font-size: 0.95rem;">
                                <a href="{{ route('news.show', $item->slug) }}">{{ $item->title }}</a>
                            </h3>
                            <div class="card-meta">
                                {{ $item->published_at ? $item->published_at->format('d/m/Y') : $item->created_at->format('d/m/Y') }}
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    @endif
@endsection
