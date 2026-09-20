<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Inicio') - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/cms.css') }}">
</head>
<body>
    <header>
        <a href="{{ route('home') }}">{{ config('app.name') }}</a>
        <nav>
            <a href="{{ route('contact.show') }}">Contacto</a>
            <a href="{{ route('login') }}">Administración</a>
        </nav>
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

    <footer>&copy; {{ date('Y') }} {{ config('app.name') }}</footer>
</body>
</html>