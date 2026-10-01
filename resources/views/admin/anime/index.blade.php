@extends('layouts.admin')

@section('title', 'Gestión de Animes')

@section('content')
    <div class="page-head">
        <div>
            <h1>Catálogo de Animes</h1>
            <p class="muted" style="margin: 4px 0 0;">Total de títulos registrados: {{ $animes->total() }}</p>
        </div>
        <a href="{{ route('admin.anime.create') }}" class="btn btn-primary">+ Nuevo Anime</a>
    </div>

    @if ($animes->isEmpty())
        <div class="card empty-state">
            <div class="icon">🎬</div>
            <h3>No hay animes registrados todavía</h3>
            <p>Comienza agregando los títulos que deseas publicar en el portal.</p>
            <a href="{{ route('admin.anime.create') }}" class="btn btn-primary" style="margin-top: 12px;">+ Agregar anime</a>
        </div>
    @else
        <div class="admin-table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width: 70px;">Póster</th>
                        <th>Título</th>
                        <th>Tipo</th>
                        <th>Estado</th>
                        <th>Año</th>
                        <th>Géneros</th>
                        <th>Etiquetas</th>
                        <th style="text-align: right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($animes as $item)
                        <tr>
                            <td>
                                @if ($item->media)
                                    <img src="{{ $item->media->url }}" alt="{{ $item->title }}">
                                @else
                                    <div style="width: 60px; height: 45px; background: var(--card2); border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; color: var(--muted);">Sin foto</div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $item->title }}</strong>
                                @if ($item->title_alt)
                                    <div class="muted" style="font-size: 0.8rem;">{{ $item->title_alt }}</div>
                                @endif
                            </td>
                            <td><span class="badge" style="background: var(--card2); color: var(--text);">{{ $item->type }}</span></td>
                            <td>
                                @php
                                    $class = match($item->status) {
                                        'En emisión' => 'status-emision',
                                        'Finalizado' => 'status-finalizado',
                                        'Próximo'    => 'status-proximo',
                                        'Pausado'    => 'status-pausado',
                                        'Cancelado'  => 'status-cancelado',
                                        default      => 'badge-off',
                                    };
                                @endphp
                                <span class="badge {{ $class }}">{{ $item->status }}</span>
                            </td>
                            <td>{{ $item->year ?? '—' }}</td>
                            <td>
                                <div style="display: flex; flex-wrap: wrap; gap: 4px; max-width: 220px;">
                                    @foreach ($item->genres as $g)
                                        <span class="genre-tag" style="font-size: 10px; padding: 1px 6px;">{{ $g->name }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td>
                                @if ($item->is_featured)
                                    <span class="badge badge-on" title="Destacado en portada">⭐ Destacado</span>
                                @endif
                                @if ($item->is_trending)
                                    <span class="badge" style="background: rgba(245, 158, 11, 0.2); color: var(--accent);" title="Tendencia">🔥 Tendencia</span>
                                @endif
                                @if ($item->is_classic)
                                    <span class="badge" style="background: rgba(147, 51, 234, 0.2); color: #c084fc;" title="Clásico">📜 Clásico</span>
                                @endif
                            </td>
                            <td>
                                <div class="actions-row" style="justify-content: flex-end;">
                                    <a href="{{ route('anime.show', $item->slug) }}" target="_blank" class="btn btn-sm btn-outline" title="Ver en portal">Ver ↗</a>
                                    <a href="{{ route('admin.anime.edit', $item) }}" class="btn btn-sm btn-primary">Editar</a>
                                    <form action="{{ route('admin.anime.destroy', $item) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este anime?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin-top: 16px;">
            {{ $animes->links() }}
        </div>
    @endif
@endsection
