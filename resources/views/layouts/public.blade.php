<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Inicio') - {{ config('app.name', 'ANIMEVERSE') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="{{ asset('css/cms.css') }}">
</head>
<body>
    <header class="navbar">
        <a href="{{ route('home') }}" class="navbar-brand">⚡ {{ config('app.name', 'ANIMEVERSE') }}</a>

        <button class="navbar-toggle" onclick="document.querySelector('.navbar-menu').classList.toggle('open')" aria-label="Menú">
            ☰
        </button>

        <nav class="navbar-menu">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Inicio</a>
            <a href="{{ route('news.index') }}" class="{{ request()->routeIs('news.*') ? 'active' : '' }}">Noticias</a>
            <a href="{{ route('anime.trending') }}" class="{{ request()->routeIs('anime.trending') ? 'active' : '' }}">Tendencias</a>
            <a href="{{ route('anime.index') }}" class="{{ request()->routeIs('anime.index') || request()->routeIs('anime.show') ? 'active' : '' }}">Animes</a>
            <a href="{{ route('genre.index') }}" class="{{ request()->routeIs('genre.*') ? 'active' : '' }}">Géneros</a>
            <a href="{{ route('anime.upcoming') }}" class="{{ request()->routeIs('anime.upcoming') ? 'active' : '' }}">Próximos</a>
            <a href="{{ route('anime.classics') }}" class="{{ request()->routeIs('anime.classics') ? 'active' : '' }}">Clásicos</a>
            <a href="{{ route('anime.finished') }}" class="{{ request()->routeIs('anime.finished') ? 'active' : '' }}">Finalizados</a>
            <a href="{{ route('contact.show') }}" class="{{ request()->routeIs('contact.*') ? 'active' : '' }}">Contacto</a>

            @auth
                <a href="{{ route('admin.dashboard') }}" class="btn btn-accent btn-sm" style="border-radius: 20px;">⚙ Panel Admin</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline btn-sm" style="border-radius: 20px;">Ingresar</a>
            @endauth
        </nav>

        <form action="{{ route('anime.index') }}" method="GET" class="navbar-search">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar anime...">
            <button type="submit">🔍</button>
        </form>
    </header>

    <main>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <footer>
        <p style="font-size:1.5rem; margin-bottom:8px;">⚡ <strong>{{ config('app.name', 'ANIMEVERSE') }}</strong></p>
        <p>Tu portal definitivo de noticias y catálogo de anime.</p>
        <p style="margin-top:12px;">© {{ date('Y') }} {{ config('app.name', 'ANIMEVERSE') }} · Todos los derechos reservados.</p>
    </footer>

    <script>
        // ── Drag-to-scroll carousel con soporte para clics ───
        document.querySelectorAll('.carousel-track-container').forEach(container => {
            let isDown = false, startX, scrollLeft, hasDragged = false;

            container.addEventListener('mousedown', e => {
                isDown = true;
                hasDragged = false;
                container.style.cursor = 'grabbing';
                startX     = e.pageX - container.offsetLeft;
                scrollLeft = container.scrollLeft;
            });

            container.addEventListener('mouseleave', () => { 
                isDown = false; 
                container.style.cursor = 'grab'; 
            });

            container.addEventListener('mouseup', () => { 
                isDown = false; 
                container.style.cursor = 'grab'; 
            });

            container.addEventListener('mousemove', e => {
                if (!isDown) return;
                const x = e.pageX - container.offsetLeft;
                if (Math.abs(x - startX) > 6) {
                    hasDragged = true;
                }
                e.preventDefault();
                const walk = (x - startX) * 1.6;
                container.scrollLeft = scrollLeft - walk;
            });

            // Evita navegación accidental si el usuario estaba arrastrando el carrusel
            container.addEventListener('click', e => {
                if (hasDragged) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            }, true);
        });

        // ── Botones de navegación del carrusel ───────────────
        document.querySelectorAll('.carousel-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const container = btn.closest('.carousel-wrapper').querySelector('.carousel-track-container');
                const dir       = btn.dataset.dir === 'prev' ? -1 : 1;
                container.scrollBy({ left: dir * 600, behavior: 'smooth' });
            });
        });

        // ── Tarjetas interactivas: toda la tarjeta o póster abre el detalle ──
        document.querySelectorAll('.card-item').forEach(card => {
            const mainLink = card.querySelector('.card-title a');
            if (mainLink) {
                card.style.cursor = 'pointer';
                card.addEventListener('click', e => {
                    // Si se hizo clic en un enlace específico dentro (ej. tag de género), no interceptar
                    const clickedLink = e.target.closest('a');
                    if (clickedLink && clickedLink !== mainLink) {
                        return;
                    }
                    if (!e.target.closest('button')) {
                        window.location.href = mainLink.href;
                    }
                });
            }
        });
    </script>
</body>
</html>