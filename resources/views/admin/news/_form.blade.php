@php
    $selectedMedia = old('media_id', $news->media_id ?? null);
@endphp

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
    <!-- Columna Principal -->
    <div>
        <label for="title">Título de la noticia *</label>
        <input
            type="text"
            id="title"
            name="title"
            value="{{ old('title', $news->title ?? '') }}"
            maxlength="255"
            required
            placeholder="Ej: Anuncian nueva temporada de Bleach"
        >

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div>
                <label for="category_id">Categoría</label>
                <select id="category_id" name="category_id">
                    <option value="">-- Sin categoría --</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $news->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="anime_id">Anime Relacionado (Opcional)</label>
                <select id="anime_id" name="anime_id">
                    <option value="">-- Ninguno en específico --</option>
                    @foreach ($animes as $ani)
                        <option value="{{ $ani->id }}" {{ old('anime_id', $news->anime_id ?? '') == $ani->id ? 'selected' : '' }}>
                            {{ $ani->title }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <label for="excerpt">Resumen corto (Lead)</label>
        <textarea
            id="excerpt"
            name="excerpt"
            rows="2"
            maxlength="500"
            placeholder="Breve introducción que aparecerá en las tarjetas..."
        >{{ old('excerpt', $news->excerpt ?? '') }}</textarea>

        <label for="content">Contenido completo de la noticia *</label>
        <textarea
            id="content"
            name="content"
            rows="10"
            required
            placeholder="Escribe aquí el texto detallado de la noticia..."
        >{{ old('content', $news->content ?? '') }}</textarea>
    </div>

    <!-- Columna Lateral -->
    <div>
        <div style="background: var(--bg2); border: 1px solid var(--border); border-radius: var(--radius); padding: 16px; margin-bottom: 20px;">
            <h3 style="font-size: 0.95rem; margin-bottom: 12px; color: var(--accent);">Publicación</h3>

            <label for="status">Estado de la noticia *</label>
            <select id="status" name="status" required>
                <option value="borrador" {{ old('status', $news->status ?? 'borrador') === 'borrador' ? 'selected' : '' }}>
                    📝 Borrador (No visible)
                </option>
                <option value="publicada" {{ old('status', $news->status ?? 'borrador') === 'publicada' ? 'selected' : '' }}>
                    ✅ Publicada (Visible a todos)
                </option>
                <option value="archivada" {{ old('status', $news->status ?? 'borrador') === 'archivada' ? 'selected' : '' }}>
                    📦 Archivada
                </option>
            </select>

            <label for="author">Autor</label>
            <input
                type="text"
                id="author"
                name="author"
                value="{{ old('author', $news->author ?? auth()->user()->name ?? 'Redacción') }}"
                placeholder="Nombre del redactor"
            >
        </div>

        <!-- Imagen de portada -->
        <label>Imagen de portada</label>
        <div class="media-picker" style="max-height: 240px; overflow-y: auto;">
            <label class="picker-item" style="display: flex; flex-direction: column; justify-content: center; align-items: center; min-height: 80px;">
                <input type="radio" name="media_id" value="" {{ blank($selectedMedia) ? 'checked' : '' }}>
                <span style="margin-top: 4px;">Sin imagen</span>
            </label>

            @foreach ($media as $item)
                <label class="picker-item {{ (string) $selectedMedia === (string) $item->id ? 'selected' : '' }}">
                    <input type="radio" name="media_id" value="{{ $item->id }}" {{ (string) $selectedMedia === (string) $item->id ? 'checked' : '' }}>
                    <img src="{{ $item->url }}" alt="{{ $item->name }}">
                    <span>{{ Str::limit($item->name, 12) }}</span>
                </label>
            @endforeach
        </div>
        <p class="form-hint">
            ¿Nueva imagen? <a href="{{ route('admin.media.index') }}" target="_blank">Súbela aquí</a>.
        </p>

        <div style="margin-top: 24px;">
            <button type="submit" class="btn btn-primary" style="width: 100%;">
                {{ isset($news) ? 'Guardar Cambios' : 'Crear Noticia' }}
            </button>
            <a href="{{ route('admin.news.index') }}" class="btn btn-outline" style="width: 100%; text-align: center; margin-top: 8px;">
                Cancelar
            </a>
        </div>
    </div>
</div>
</label>