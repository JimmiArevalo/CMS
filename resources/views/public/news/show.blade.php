@extends('layouts.public')

@section('title', $item->title)

@section('content')
    <article style="max-width: 860px; margin: 0 auto;">
        <div style="margin-bottom: 20px;">
            <a href="{{ route('news.index') }}" class="muted" style="font-size: 0.85rem;">← Volver a Noticias</a>
        </div>

        <header class="article-header">
            @if ($item->category)
                <span class="hero-category">{{ $item->category->name }}</span>
            @endif

            <h1 style="margin-top: 10px; font-size: 2.2rem;">{{ $item->title }}</h1>

            <div class="article-meta">
                <span>✍️ Por <strong>{{ $item->author ?? 'Redacción' }}</strong></span>
                <span>📅 {{ $item->published_at ? $item->published_at->format('d \d\e F \d\e Y') : $item->created_at->format('d/m/Y') }}</span>
                @if ($item->anime)
                    <span>🎬 Anime: <a href="{{ route('anime.show', $item->anime->slug) }}" style="color: var(--accent); font-weight: bold;">{{ $item->anime->title }}</a></span>
                @endif
            </div>
        </header>

        @if ($item->media)
            <div class="page-hero">
                <img src="{{ $item->media->url }}" alt="{{ $item->title }}">
            </div>
        @endif

        @if ($item->excerpt)
            <p style="font-size: 1.2rem; color: #cbd5e1; font-weight: 500; line-height: 1.6; margin-bottom: 24px; border-left: 3px solid var(--accent); padding-left: 16px;">
                {{ $item->excerpt }}
            </p>
        @endif

        <div class="article-content">
            {!! nl2br(e($item->content)) !!}
        </div>

        <!-- Noticias Relacionadas -->
        @if ($related->isNotEmpty())
            <div style="margin-top: 60px; padding-top: 32px; border-top: 1px solid var(--border);">
                <h3 class="section-title">Noticias Relacionadas</h3>
                <div class="cards-grid">
                    @foreach ($related as $rel)
                        <article class="card-item">
                            @if ($rel->media)
                                <img src="{{ $rel->media->url }}" alt="{{ $rel->title }}" class="card-img" style="height: 140px;">
                            @endif
                            <div class="card-body">
                                <h4 class="card-title" style="font-size: 0.95rem;">
                                    <a href="{{ route('news.show', $rel->slug) }}">{{ $rel->title }}</a>
                                </h4>
                                <div class="card-meta">
                                    {{ $rel->published_at ? $rel->published_at->format('d/m/Y') : $rel->created_at->format('d/m/Y') }}
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        @endif
    </article>
@endsection
