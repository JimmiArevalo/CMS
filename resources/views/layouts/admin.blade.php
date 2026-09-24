<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel') - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/cms.css') }}">
</head>
<body>
    <header>
        <nav>
            <a href="{{ route('admin.media.index') }}">{{ config('app.name') }} · Panel</a>

            @auth
                <a href="{{ route('admin.media.index') }}">Multimedia</a>
                <a href="{{ route('admin.news.index') }}">Noticias</a>
                <a href="{{ route('admin.register') }}">Nuevo usuario</a>
                <a href="{{ route('home') }}" target="_blank" rel="noopener">Ver sitio</a>
            @endauth
        </nav>

        @auth
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">Cerrar sesión</button>
            </form>
        @endauth
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
</body>
</html>