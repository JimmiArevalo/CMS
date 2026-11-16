@extends('layouts.admin')

@section('title', 'Panel de Control')

@section('content')
<style>
    /* Estilos específicos para un Dashboard intuitivo y llamativo */
    .dashboard-hero {
        background: linear-gradient(135deg, rgba(244, 117, 33, 0.12) 0%, rgba(124, 58, 237, 0.1) 100%), var(--card);
        border: 1px solid rgba(244, 117, 33, 0.25);
        border-radius: 14px;
        padding: 24px 28px;
        margin-bottom: 28px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
    }
    .dashboard-hero h1 {
        font-size: 1.85rem;
        font-weight: 800;
        color: #ffffff;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .dashboard-hero p {
        color: var(--muted);
        margin: 6px 0 0;
        font-size: 0.95rem;
    }
    .user-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(244, 117, 33, 0.18);
        border: 1px solid rgba(244, 117, 33, 0.4);
        color: var(--accent);
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Grid de métricas / Stats */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 32px;
    }
    .stat-box {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 20px;
        position: relative;
        overflow: hidden;
        transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .stat-box:hover {
        transform: translateY(-3px);
        border-color: var(--accent);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.35);
    }
    .stat-box-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
    }
    .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        background: var(--card2);
    }
    .stat-value {
        font-size: 2.2rem;
        font-weight: 900;
        line-height: 1;
        color: #ffffff;
        margin-bottom: 4px;
    }
    .stat-title {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .stat-footer {
        margin-top: 14px;
        padding-top: 12px;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 0.8rem;
    }
    .stat-pill {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 0.75rem;
    }

    /* Acciones Rápidas */
    .quick-actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 20px;
        margin-bottom: 32px;
    }
    .action-card {
        background: linear-gradient(180deg, var(--card) 0%, var(--bg2) 100%);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 22px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: all 0.2s ease;
    }
    .action-card:hover {
        border-color: rgba(244, 117, 33, 0.4);
        transform: translateY(-2px);
    }
    .action-card h3 {
        font-size: 1.15rem;
        color: #ffffff;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .action-card p {
        font-size: 0.85rem;
        color: var(--muted);
        line-height: 1.5;
        margin-bottom: 18px;
        flex-grow: 1;
    }
    .action-buttons {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    /* Grid de Contenido Reciente */
    .recent-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }
    @media (max-width: 900px) {
        .recent-grid {
            grid-template-columns: 1fr;
        }
    }
    .panel-block {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 22px;
    }
    .panel-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
        padding-bottom: 12px;
        border-bottom: 1px solid var(--border);
    }
    .panel-header h2 {
        font-size: 1.2rem;
        color: #ffffff;
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .panel-link {
        font-size: 0.85rem;
        color: var(--accent);
        font-weight: 700;
        text-decoration: none;
    }
    .panel-link:hover {
        text-decoration: underline;
    }

    /* Items de Noticias Recientes */
    .news-mini-item {
        display: flex;
        gap: 14px;
        padding: 10px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.04);
        align-items: center;
    }
    .news-mini-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    .news-mini-img {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        object-fit: cover;
        background: var(--card2);
        flex-shrink: 0;
    }
    .news-mini-content {
        flex: 1;
        min-width: 0;
    }
    .news-mini-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .news-mini-meta {
        font-size: 0.75rem;
        color: var(--muted);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Mini Grid de Animes Recientes */
    .anime-mini-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
        gap: 12px;
    }
    .anime-mini-card {
        background: var(--card2);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.2s ease;
        text-decoration: none;
        display: flex;
        flex-direction: column;
    }
    .anime-mini-card:hover {
        transform: translateY(-3px);
        border-color: var(--accent);
    }
    .anime-mini-thumb {
        width: 100%;
        height: 140px;
        object-fit: cover;
        background: var(--bg);
    }
    .anime-mini-info {
        padding: 8px;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .anime-mini-name {
        font-size: 0.8rem;
        font-weight: 700;
        color: #ffffff;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<!-- ══ Cabecera Principal del Panel ═════════════════════════ -->
<div class="dashboard-hero">
    <div>
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px;">
            <h1>⚡ Panel de Control</h1>
            <span class="user-pill">Admin: {{ auth()->user()->name ?? 'Administrador' }}</span>
        </div>
        <p>Centro de mando general para contenidos, catálogo de series, portadas y noticias de <strong>{{ config('app.name', 'ANIMEVERSE') }}</strong>.</p>
    </div>

    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary" style="font-weight: 700; box-shadow: 0 4px 14px rgba(244, 117, 33, 0.35);">
            + Redactar Noticia
        </a>
        <a href="{{ route('admin.anime.create') }}" class="btn btn-outline" style="font-weight: 700;">
            + Nuevo Anime
        </a>
        <a href="{{ route('home') }}" target="_blank" rel="noopener" class="btn btn-outline" style="border-color: rgba(255,255,255,0.15);">
            Ver Sitio ↗
        </a>
    </div>
</div>

<!-- ══ Tarjetas de Estadísticas Principales ═════════════════ -->
<div class="stats-container">
    <!-- Noticias -->
    <div class="stat-box">
        <div class="stat-box-top">
            <div>
                <div class="stat-title">Noticias</div>
                <div class="stat-value" style="color: var(--accent);">{{ $stats['total_news'] }}</div>
            </div>
            <div class="stat-icon" style="color: var(--accent); background: rgba(244, 117, 33, 0.15);">📰</div>
        </div>
        <div class="stat-footer">
            <span class="stat-pill" style="background: rgba(34, 197, 94, 0.18); color: #4ade80;">
                ✓ {{ $stats['published_news'] }} Publicadas
            </span>
            <a href="{{ route('admin.news.index') }}" style="color: var(--accent); font-weight: 700; text-decoration: none;">Ver todas →</a>
        </div>
    </div>

    <!-- Animes -->
    <div class="stat-box">
        <div class="stat-box-top">
            <div>
                <div class="stat-title">Catálogo Animes</div>
                <div class="stat-value" style="color: #60a5fa;">{{ $stats['total_animes'] }}</div>
            </div>
            <div class="stat-icon" style="color: #60a5fa; background: rgba(96, 165, 250, 0.15);">🎬</div>
        </div>
        <div class="stat-footer">
            <span class="stat-pill" style="background: rgba(96, 165, 250, 0.18); color: #93c5fd;">
                ● {{ $stats['airing_animes'] }} En emisión · {{ $stats['upcoming'] }} Próximos
            </span>
            <a href="{{ route('admin.anime.index') }}" style="color: #60a5fa; font-weight: 700; text-decoration: none;">Explorar →</a>
        </div>
    </div>

    <!-- Géneros -->
    <div class="stat-box">
        <div class="stat-box-top">
            <div>
                <div class="stat-title">Géneros y Temáticas</div>
                <div class="stat-value" style="color: #c084fc;">{{ $stats['genres'] }}</div>
            </div>
            <div class="stat-icon" style="color: #c084fc; background: rgba(192, 132, 252, 0.15);">🏷️</div>
        </div>
        <div class="stat-footer">
            <span class="stat-pill" style="background: rgba(192, 132, 252, 0.18); color: #d8b4fe;">
                34 Filtros activos
            </span>
            <a href="{{ route('admin.genre.index') }}" style="color: #c084fc; font-weight: 700; text-decoration: none;">Gestionar →</a>
        </div>
    </div>

    <!-- Multimedia -->
    <div class="stat-box">
        <div class="stat-box-top">
            <div>
                <div class="stat-title">Multimedia</div>
                <div class="stat-value" style="color: #34d399;">{{ $stats['total_media'] }}</div>
            </div>
            <div class="stat-icon" style="color: #34d399; background: rgba(52, 211, 153, 0.15);">🖼️</div>
        </div>
        <div class="stat-footer">
            <span class="stat-pill" style="background: rgba(52, 211, 153, 0.18); color: #6ee7b7;">
                Portadas y Banners
            </span>
            <a href="{{ route('admin.media.index') }}" style="color: #34d399; font-weight: 700; text-decoration: none;">Biblioteca →</a>
        </div>
    </div>
</div>

<!-- ══ Accesos Rápidos de Administración ════════════════════ -->
<div class="quick-actions-grid">
    <div class="action-card">
        <div>
            <h3>📰 Noticias y Artículos</h3>
            <p>Redacta coberturas de estrenos, reseñas de capítulos, entrevistas y comunicados de la industria del anime.</p>
        </div>
        <div class="action-buttons">
            <a href="{{ route('admin.news.create') }}" class="btn btn-sm btn-primary">+ Redactar Noticia</a>
            <a href="{{ route('admin.news.index') }}" class="btn btn-sm btn-outline">Listado General</a>
        </div>
    </div>

    <div class="action-card">
        <div>
            <h3>🎬 Fichas de Anime</h3>
            <p>Añade nuevas series, películas, temporadas, sinopsis, estudios de animación y actualiza el estado de emisión.</p>
        </div>
        <div class="action-buttons">
            <a href="{{ route('admin.anime.create') }}" class="btn btn-sm btn-primary" style="background: #2563eb; border-color: #2563eb;">+ Registrar Anime</a>
            <a href="{{ route('admin.anime.index') }}" class="btn btn-sm btn-outline">Ver Catálogo</a>
        </div>
    </div>

    <div class="action-card">
        <div>
            <h3>🏷️ Géneros & Clasificación</h3>
            <p>Crea y edita las categorías temáticas que permiten a los usuarios filtrar animes por sus preferencias.</p>
        </div>
        <div class="action-buttons">
            <a href="{{ route('admin.genre.index') }}" class="btn btn-sm btn-primary" style="background: #7c3aed; border-color: #7c3aed;">+ Gestionar Géneros</a>
        </div>
    </div>

    <div class="action-card">
        <div>
            <h3>🖼️ Archivos y Media</h3>
            <p>Sube imágenes de portadas oficiales, pósters promocionales y banners para asignarlos a animes y noticias.</p>
        </div>
        <div class="action-buttons">
            <a href="{{ route('admin.media.index') }}" class="btn btn-sm btn-primary" style="background: #059669; border-color: #059669;">+ Subir / Ver Imágenes</a>
        </div>
    </div>
</div>

<!-- ══ Actividad Reciente (Noticias + Animes) ════════════════ -->
<div class="recent-grid">
    <!-- Últimas Noticias Creadas -->
    <div class="panel-block">
        <div class="panel-header">
            <h2>📰 Últimas Noticias</h2>
            <a href="{{ route('admin.news.index') }}" class="panel-link">Ver todas ({{ $stats['total_news'] }}) →</a>
        </div>

        <div>
            @forelse ($recentNews as $item)
                <div class="news-mini-item">
                    @if ($item->media)
                        <img src="{{ $item->media->url }}" alt="{{ $item->title }}" class="news-mini-img">
                    @else
                        <div class="news-mini-img" style="display:flex;align-items:center;justify-content:center;color:var(--muted);">📰</div>
                    @endif

                    <div class="news-mini-content">
                        <div class="news-mini-title" title="{{ $item->title }}">
                            <a href="{{ route('admin.news.edit', $item->id) }}" style="color: #ffffff; text-decoration: none;">
                                {{ $item->title }}
                            </a>
                        </div>
                        <div class="news-mini-meta">
                            <span style="color: var(--accent); font-weight: 700;">{{ $item->category->name ?? 'General' }}</span>
                            <span>•</span>
                            <span>{{ $item->published_at ? $item->published_at->format('d/m/Y') : 'Borrador' }}</span>
                        </div>
                    </div>

                    <div style="display: flex; gap: 6px;">
                        <a href="{{ route('admin.news.edit', $item->id) }}" class="btn btn-sm btn-outline" style="padding: 4px 10px; font-size: 0.75rem;">Editar</a>
                    </div>
                </div>
            @empty
                <p class="muted">No hay noticias registradas todavía.</p>
            @endforelse
        </div>
    </div>

    <!-- Últimos Animes Registrados -->
    <div class="panel-block">
        <div class="panel-header">
            <h2>🎬 Últimos Animes Agregados</h2>
            <a href="{{ route('admin.anime.index') }}" class="panel-link">Ver catálogo ({{ $stats['total_animes'] }}) →</a>
        </div>

        <div class="anime-mini-grid">
            @forelse ($recentAnimes as $anime)
                <a href="{{ route('admin.anime.edit', $anime->id) }}" class="anime-mini-card">
                    @if ($anime->media)
                        <img src="{{ $anime->media->url }}" alt="{{ $anime->title }}" class="anime-mini-thumb">
                    @else
                        <div class="anime-mini-thumb" style="display:flex;align-items:center;justify-content:center;color:var(--muted);">🎬</div>
                    @endif
                    <div class="anime-mini-info">
                        <div class="anime-mini-name" title="{{ $anime->title }}">{{ $anime->title }}</div>
                        <div style="margin-top: 6px; display:flex; justify-content:space-between; align-items:center;">
                            <span style="font-size: 0.7rem; color: var(--accent); font-weight: 700;">{{ $anime->type }}</span>
                            <span style="font-size: 0.65rem; color: #4ade80;">{{ $anime->status }}</span>
                        </div>
                    </div>
                </a>
            @empty
                <p class="muted">No hay animes registrados todavía.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
