<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Inicio') - {{ config('app.name', 'ANIMEVERSE') }}</title>
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
                <a href="{{ route('admin.dashboard') }}" style="background: var(--accent); color: #000; font-weight: bold;">Panel Admin</a>
            @else
                <a href="{{ route('login') }}" style="border: 1px solid var(--border);">Ingresar</a>
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
        <p><strong>{{ config('app.name', 'ANIMEVERSE') }}</strong> — Tu portal definitivo de noticias y catálogo de anime.</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name', 'ANIMEVERSE') }} · Todos los derechos reservados.</p>
    </footer>
</body>
</html>
</html>