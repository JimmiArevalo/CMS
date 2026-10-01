@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="page-head">
        <div>
            <h1>Panel de Control</h1>
            <p class="muted" style="margin: 4px 0 0;">Bienvenido a la administración de {{ config('app.name', 'ANIMEVERSE') }}</p>
        </div>
        <div style="display: flex; gap: 8px;">
            <a href="{{ route('admin.news.create') }}" class="btn btn-primary btn-sm">+ Nueva Noticia</a>
            <a href="{{ route('admin.anime.create') }}" class="btn btn-accent btn-sm">+ Nuevo Anime</a>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">{{ $stats['total_news'] }}</div>
            <div class="stat-label">Total Noticias</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" style="color: var(--success);">{{ $stats['published_news'] }}</div>
            <div class="stat-label">Noticias Publicadas</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" style="color: var(--accent);">{{ $stats['draft_news'] }}</div>
            <div class="stat-label">Borradores</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $stats['total_animes'] }}</div>
            <div class="stat-label">Total Animes</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" style="color: #60a5fa;">{{ $stats['upcoming'] }}</div>
            <div class="stat-label">Próximos Estrenos</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" style="color: #c084fc;">{{ $stats['genres'] }}</div>
            <div class="stat-label">Géneros Registrados</div>
        </div>
    </div>

    <!-- Accesos directos y gestión -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
        <div class="card" style="background: var(--card); border: 1px solid var(--border); border-radius: var(--radius); padding: 20px;">
            <h2 style="font-size: 1.1rem; margin-bottom: 12px; color: var(--accent);">Gestión de Noticias</h2>
            <p class="muted" style="font-size: 0.85rem; margin-bottom: 16px;">Crea, edita, redacta borradores y publica noticias sobre la industria y lanzamientos de anime.</p>
            <div style="display: flex; gap: 10px;">
                <a href="{{ route('admin.news.index') }}" class="btn btn-sm btn-outline">Ver listado</a>
                <a href="{{ route('admin.news.create') }}" class="btn btn-sm btn-primary">+ Redactar noticia</a>
            </div>
        </div>

        <div class="card" style="background: var(--card); border: 1px solid var(--border); border-radius: var(--radius); padding: 20px;">
            <h2 style="font-size: 1.1rem; margin-bottom: 12px; color: var(--accent);">Catálogo de Animes</h2>
            <p class="muted" style="font-size: 0.85rem; margin-bottom: 16px;">Administra títulos, sinopsis, temporadas, estado (emisión, finalizado, próximos), año y pósteres.</p>
            <div style="display: flex; gap: 10px;">
                <a href="{{ route('admin.anime.index') }}" class="btn btn-sm btn-outline">Ver animes</a>
                <a href="{{ route('admin.anime.create') }}" class="btn btn-sm btn-accent">+ Registrar anime</a>
            </div>
        </div>

        <div class="card" style="background: var(--card); border: 1px solid var(--border); border-radius: var(--radius); padding: 20px;">
            <h2 style="font-size: 1.1rem; margin-bottom: 12px; color: var(--accent);">Géneros y Categorías</h2>
            <p class="muted" style="font-size: 0.85rem; margin-bottom: 16px;">Administra los géneros vinculados a los animes (Acción, Isekai, Shonen, etc.).</p>
            <div style="display: flex; gap: 10px;">
                <a href="{{ route('admin.genre.index') }}" class="btn btn-sm btn-outline">Gestionar géneros</a>
            </div>
        </div>

        <div class="card" style="background: var(--card); border: 1px solid var(--border); border-radius: var(--radius); padding: 20px;">
            <h2 style="font-size: 1.1rem; margin-bottom: 12px; color: var(--accent);">Biblioteca Multimedia</h2>
            <p class="muted" style="font-size: 0.85rem; margin-bottom: 16px;">Sube y administra imágenes de pósteres y portadas para noticias y animes.</p>
            <div style="display: flex; gap: 10px;">
                <a href="{{ route('admin.media.index') }}" class="btn btn-sm btn-outline">Ver imágenes</a>
            </div>
        </div>
    </div>
@endsection
