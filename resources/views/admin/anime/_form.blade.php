@csrf

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
    <!-- Columna Principal -->
    <div>
        <label for="title">Título del anime *</label>
        <input
            type="text"
            id="title"
            name="title"
            value="{{ old('title', $anime->title ?? '') }}"
            required
            placeholder="Ej: Jujutsu Kaisen"
        >

        <label for="title_alt">Título alternativo / Japonés</label>
        <input
            type="text"
            id="title_alt"
            name="title_alt"
            value="{{ old('title_alt', $anime->title_alt ?? '') }}"
            placeholder="Ej: 呪術廻戦 / Sorcery Fight"
        >

        <label for="synopsis">Sinopsis</label>
        <textarea
            id="synopsis"
            name="synopsis"
            rows="6"
            placeholder="Escribe la sinopsis o argumento de la serie..."
        >{{ old('synopsis', $anime->synopsis ?? '') }}</textarea>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div>
                <label for="studio">Estudio de animación</label>
                <input
                    type="text"
                    id="studio"
                    name="studio"
                    value="{{ old('studio', $anime->studio ?? '') }}"
                    placeholder="Ej: MAPPA, Bones, ufotable"
                >
            </div>
            <div>
                <label for="year">Año de lanzamiento</label>
                <input
                    type="number"
                    id="year"
                    name="year"
                    min="1950"
                    max="2035"
                    value="{{ old('year', $anime->year ?? date('Y')) }}"
                >
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div>
                <label for="type">Formato / Tipo *</label>
                <select id="type" name="type" required>
                    @foreach (['Serie', 'Película', 'OVA', 'ONA'] as $tipo)
                        <option value="{{ $tipo }}" {{ old('type', $anime->type ?? 'Serie') === $tipo ? 'selected' : '' }}>
                            {{ $tipo }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="status">Estado de emisión *</label>
                <select id="status" name="status" required>
                    @foreach (['En emisión', 'Finalizado', 'Próximo', 'Pausado', 'Cancelado'] as $est)
                        <option value="{{ $est }}" {{ old('status', $anime->status ?? 'Próximo') === $est ? 'selected' : '' }}>
                            {{ $est }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px;">
            <div>
                <label for="seasons">Temporadas</label>
                <input
                    type="number"
                    id="seasons"
                    name="seasons"
                    min="1"
                    value="{{ old('seasons', $anime->seasons ?? 1) }}"
                >
            </div>
            <div>
                <label for="aired_from">Fecha de estreno</label>
                <input
                    type="date"
                    id="aired_from"
                    name="aired_from"
                    value="{{ old('aired_from', isset($anime->aired_from) ? $anime->aired_from->format('Y-m-d') : '') }}"
                >
            </div>
            <div>
                <label for="aired_to">Fecha de fin</label>
                <input
                    type="date"
                    id="aired_to"
                    name="aired_to"
                    value="{{ old('aired_to', isset($anime->aired_to) ? $anime->aired_to->format('Y-m-d') : '') }}"
                >
            </div>
        </div>

        <!-- Selección de Géneros -->
        <label>Géneros asociados</label>
        @php
            $selectedGenres = old('genres', isset($anime) ? $anime->genres->pluck('id')->toArray() : []);
        @endphp
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: 8px; margin-top: 6px;">
            @foreach ($genres as $genre)
                <label class="check" style="margin: 0; font-size: 0.85rem; background: var(--bg2); padding: 6px 10px; border-radius: 6px; border: 1px solid var(--border);">
                    <input
                        type="checkbox"
                        name="genres[]"
                        value="{{ $genre->id }}"
                        {{ in_array($genre->id, $selectedGenres) ? 'checked' : '' }}
                    >
                    {{ $genre->name }}
                </label>
            @endforeach
        </div>
    </div>

    <!-- Columna Lateral: Imagen y Opciones -->
    <div>
        <div style="background: var(--bg2); border: 1px solid var(--border); border-radius: var(--radius); padding: 16px; margin-bottom: 20px;">
            <h3 style="font-size: 0.95rem; margin-bottom: 12px; color: var(--accent);">Opciones de visibilidad</h3>

            <label class="check">
                <input
                    type="checkbox"
                    name="is_featured"
                    value="1"
                    {{ old('is_featured', $anime->is_featured ?? false) ? 'checked' : '' }}
                >
                Destacar en portada
            </label>

            <label class="check">
                <input
                    type="checkbox"
                    name="is_trending"
                    value="1"
                    {{ old('is_trending', $anime->is_trending ?? false) ? 'checked' : '' }}
                >
                Marcar como Tendencia
            </label>

            <label class="check">
                <input
                    type="checkbox"
                    name="is_classic"
                    value="1"
                    {{ old('is_classic', $anime->is_classic ?? false) ? 'checked' : '' }}
                >
                Es un clásico del anime
            </label>
        </div>

        <!-- Imagen / Póster -->
        <label>Póster o Portada</label>
        <p class="form-hint">Selecciona una imagen de la biblioteca:</p>

        <div class="media-picker" style="max-height: 280px; overflow-y: auto;">
            <label class="picker-item" style="display: flex; flex-direction: column; justify-content: center; align-items: center; min-height: 90px;">
                <input
                    type="radio"
                    name="media_id"
                    value=""
                    {{ old('media_id', $anime->media_id ?? null) === null ? 'checked' : '' }}
                >
                <span style="margin-top: 4px;">Sin imagen</span>
            </label>

            @foreach ($media as $item)
                <label class="picker-item {{ old('media_id', $anime->media_id ?? null) == $item->id ? 'selected' : '' }}">
                    <input
                        type="radio"
                        name="media_id"
                        value="{{ $item->id }}"
                        {{ old('media_id', $anime->media_id ?? null) == $item->id ? 'checked' : '' }}
                    >
                    <img src="{{ $item->url }}" alt="{{ $item->name }}">
                    <span>{{ Str::limit($item->name, 12) }}</span>
                </label>
            @endforeach
        </div>
        <p class="form-hint" style="margin-top: 8px;">
            ¿Necesitas otra imagen? <a href="{{ route('admin.media.index') }}" target="_blank">Súbela en multimedia</a>.
        </p>

        <div style="margin-top: 24px;">
            <button type="submit" class="btn btn-primary" style="width: 100%;">
                {{ isset($anime) ? 'Actualizar Anime' : 'Registrar Anime' }}
            </button>
            <a href="{{ route('admin.anime.index') }}" class="btn btn-outline" style="width: 100%; text-align: center; margin-top: 8px;">
                Cancelar
            </a>
        </div>
    </div>
</div>
