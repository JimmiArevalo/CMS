@extends('layouts.admin')

@section('title', 'Noticias')

@section('content')
    <div class="page-head">
        <h1>Noticias</h1>
        <a class="btn" href="{{ route('admin.news.create') }}">Nueva noticia</a>
    </div>

    @if ($news->isEmpty())
        <p>Todavía no hay noticias.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Título</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($news as $item)
                    <tr>
                        <td>
                            @if ($item->media)
                                <img src="{{ $item->media->url }}" alt="{{ $item->title }}">
                            @else
                                <span class="muted">Sin imagen</span>
                            @endif
                        </td>
                        <td>{{ $item->title }}</td>
                        <td>
                            <span class="badge {{ $item->published ? 'badge-on' : 'badge-off' }}">
                                {{ $item->published ? 'Publicada' : 'Borrador' }}
                            </span>
                        </td>
                        <td>
                            <div class="actions-row">
                                <a href="{{ route('admin.news.edit', $item) }}">Editar</a>

                                <form
                                    action="{{ route('admin.news.destroy', $item) }}"
                                    method="POST"
                                    onsubmit="return confirm('¿Eliminar esta noticia? La imagen seguirá en la biblioteca.');"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="danger">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection