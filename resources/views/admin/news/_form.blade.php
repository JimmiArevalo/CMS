@php
    $selected = old('media_id', $news?->media_id);
@endphp

<label for="title">Título</label>
<input type="text" id="title" name="title" value="{{ old('title', $news?->title) }}" maxlength="255" required>

<label for="excerpt">Resumen (opcional)</label>
<textarea id="excerpt" name="excerpt" rows="2" maxlength="500">{{ old('excerpt', $news?->excerpt) }}</textarea>

<label for="content">Contenido</label>
<textarea id="content" name="content" rows="8" required>{{ old('content', $news?->content) }}</textarea>

<label>Imagen de la biblioteca</label>
<div class="media-picker">
    <label class="picker-item">
        <input type="radio" name="media_id" value="" @checked(blank($selected))>
        <span>Sin imagen</span>
    </label>

    @foreach ($media as $item)
        <label class="picker-item">
            <input type="radio" name="media_id" value="{{ $item->id }}" @checked((string) $selected === (string) $item->id)>
            <img src="{{ $item->url }}" alt="{{ $item->name }}">
            <span>{{ $item->name }}</span>
        </label>
    @endforeach
</div>
<p class="muted">
    ¿No está la imagen que necesitas?
    <a href="{{ route('admin.media.index') }}" target="_blank" rel="noopener">Súbela a la biblioteca</a>
    y recarga esta página.
</p>

<label class="check">
    <input type="checkbox" name="published" value="1" @checked(old('published', $news?->published))>
    Publicar en la página principal
</label>