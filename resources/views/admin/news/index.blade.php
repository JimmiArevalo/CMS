@extends('layouts.admin')

@section('title', 'Gestión de Noticias')

@section('content')
    <div class="page-head">
        <div>
            <h1>Noticias</h1>
            <p class="muted" style="margin: 4px 0 0;">Total de artículos: {{ $news->total() }}</p>
        </div>
        <a class="btn btn-primary" href="{{ route('admin.news.create') }}">+ Nueva noticia</a>
    </div>

    @if ($news->isEmpty())
        <div class="card empty-state">
            <div class="icon">📰</div>
            <h3>No hay noticias creadas todavía</h3>
            <p>Empieza redactando las noticias más destacadas de la temporada.</p>
            <a href="{{ route('admin.news.create') }}" class="btn btn-primary" style="margin-top: 12px;">+ Redactar noticia</a>
        </div>
    @else
        <div class="admin-table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width: 70px;">Portada</th>
                        <th>Título</th>
                        <th>Categoría</th>
                        <th>Autor</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th style="text-align: right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($news as $item)
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
                                @if ($item->anime)
                                    <div class="muted" style="font-size: 0.75rem;">🎬 {{ $item->anime->title }}</div>
                                @endif
                            </td>
                            <td>
                                @if ($item->category)
                                    <span class="badge" style="background: var(--card2); color: var(--accent);">{{ $item->category->name }}</span>
                                @else
                                    <span class="muted">—</span>
                                @endif
                            </td>
                            <td><span class="muted">{{ $item->author ?? '—' }}</span></td>
                            <td>
                                @if ($item->status === 'publicada')
                                    <span class="badge badge-on">Publicada</span>
                                @elseif ($item->status === 'archivada')
                                    <span class="badge badge-arch">Archivada</span>
                                @else
                                    <span class="badge badge-off">Borrador</span>
                                @endif
                            </td>
                            <td>
                                <span class="muted" style="font-size: 0.8rem;">
                                    {{ $item->published_at ? $item->published_at->format('d/m/Y') : $item->created_at->format('d/m/Y') }}
                                </span>
                            </td>
                            <td>
                                <div class="actions-row" style="justify-content: flex-end;">
                                    @if ($item->status === 'publicada')
                                        <a href="{{ route('news.show', $item->slug) }}" target="_blank" class="btn btn-sm btn-outline">Ver ↗</a>
                                    @endif

                                    <a href="{{ route('admin.news.edit', $item) }}" class="btn btn-sm btn-primary">Editar</a>

                                    <form
                                        action="{{ route('admin.news.destroy', $item) }}"
                                        method="POST"
                                        onsubmit="return confirm('¿Eliminar esta noticia?');"
                                    >
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
            {{ $news->links() }}
        </div>
    @endif
@endsection
@endsection