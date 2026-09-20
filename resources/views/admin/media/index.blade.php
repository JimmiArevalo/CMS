@extends('layouts.admin')

@section('title', 'Multimedia')

@section('content')
    <h1>Biblioteca multimedia</h1>

    <section class="card">
        <h2>Subir imagen</h2>

        <form
            action="{{ route('admin.media.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf

            <label for="name">Nombre</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" maxlength="255" required>

            <label for="file">Archivo (JPG, JPEG, PNG, WEBP o GIF, máximo 5 MB)</label>
            <input
                type="file"
                id="file"
                name="file"
                accept=".jpg,.jpeg,.png,.webp,.gif,image/jpeg,image/png,image/webp,image/gif"
                required
            >

            <button type="submit">Subir archivo</button>
        </form>
    </section>

    <section>
        <h2>Imágenes cargadas</h2>

        @if ($media->isEmpty())
            <p>Todavía no hay imágenes cargadas.</p>
        @else
            <div class="media-grid">
                @foreach ($media as $item)
                    <article class="media-card">
                        <img src="{{ $item->url }}" alt="{{ $item->name }}">
                        <div class="body">
                            <h3>{{ $item->name }}</h3>
                            <p>
                                {{ $item->mime_type }} ·
                                {{ number_format(($item->size ?? 0) / 1024, 1) }} KB
                            </p>
                            <a href="{{ $item->url }}" target="_blank" rel="noopener">Ver archivo</a>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>
@endsection