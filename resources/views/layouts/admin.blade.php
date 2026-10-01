<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel') - {{ config('app.name', 'ANIMEVERSE') }} Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="{{ asset('css/cms.css') }}">
</head>
<body class="admin-body">
    <header class="admin-header">
        <div style="display: flex; align-items: center; gap: 16px;">
            <a href="{{ route('admin.dashboard') }}" class="brand">⚡ {{ config('app.name', 'ANIMEVERSE') }} · Panel</a>

            @auth
                <nav class="admin-nav">
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
                    <a href="{{ route('admin.news.index') }}" class="{{ request()->routeIs('admin.news.*') ? 'active' : '' }}">Noticias</a>
                    <a href="{{ route('admin.anime.index') }}" class="{{ request()->routeIs('admin.anime.*') ? 'active' : '' }}">Animes</a>
                    <a href="{{ route('admin.genre.index') }}" class="{{ request()->routeIs('admin.genre.*') ? 'active' : '' }}">Géneros</a>
                    <a href="{{ route('admin.media.index') }}" class="{{ request()->routeIs('admin.media.*') ? 'active' : '' }}">Multimedia</a>
                    <a href="{{ route('register') }}" class="{{ request()->routeIs('register') ? 'active' : '' }}">+ Usuario</a>
                </nav>
            @endauth
        </div>

        <div style="display: flex; align-items: center; gap: 12px;">
            <a href="{{ route('home') }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline">
                Ver sitio ↗
            </a>

            @auth
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger">Cerrar sesión</button>
                </form>
            @endauth
        </div>
    </header>

    <main class="admin-main">
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
</body>
</html>