@extends('layouts.admin')

@section('title', 'Gestión de Géneros')

@section('content')
    <div class="page-head">
        <div>
            <h1>Géneros de Anime</h1>
            <p class="muted" style="margin: 4px 0 0;">Administra los géneros y clasificaciones disponibles en el portal.</p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px; align-items: start;">
        <!-- Formulario Crear Género -->
        <section class="form-card">
            <h2 style="font-size: 1.1rem; margin-bottom: 16px; color: var(--accent);">+ Nuevo Género</h2>

            <form action="{{ route('admin.genre.store') }}" method="POST">
                @csrf

                <label for="name">Nombre del género *</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    placeholder="Ej: Mecha, Cyberpunk, Isekai"
                >

                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 16px;">
                    Crear Género
                </button>
            </form>
        </section>

        <!-- Listado de Géneros -->
        <div class="admin-table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Género</th>
                        <th>Slug</th>
                        <th>Animes Asociados</th>
                        <th style="text-align: right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($genres as $genre)
                        <tr>
                            <td>
                                <strong>{{ $genre->name }}</strong>
                            </td>
                            <td>
                                <code style="color: var(--muted); font-size: 0.8rem;">{{ $genre->slug }}</code>
                            </td>
                            <td>
                                <span class="badge" style="background: var(--card2); color: var(--text);">
                                    {{ $genre->animes_count }} títulos
                                </span>
                            </td>
                            <td>
                                <div class="actions-row" style="justify-content: flex-end;">
                                    <a href="{{ route('genre.show', $genre->slug) }}" target="_blank" class="btn btn-sm btn-outline">Ver ↗</a>

                                    <form action="{{ route('admin.genre.destroy', $genre) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este género?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: var(--muted); padding: 24px;">
                                No hay géneros registrados aún.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
