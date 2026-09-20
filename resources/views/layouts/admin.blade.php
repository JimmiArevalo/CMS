<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel') - {{ config('app.name') }}</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #f4f6f8; color: #1f2937; }
        header { background: #022766; color: #fff; padding: 16px 24px; }
        header a { color: #fff; text-decoration: none; font-weight: bold; }
        main { max-width: 1000px; margin: 24px auto; padding: 0 16px; }
        .card { background: #fff; border-radius: 12px; padding: 20px; margin-bottom: 24px; box-shadow: 0 1px 3px rgba(0,0,0,.1); }
        label { display: block; margin: 12px 0 4px; font-weight: bold; }
        input[type=text], input[type=file] { width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 8px; background: #fff; }
        button { margin-top: 16px; background: #022766; color: #fff; border: 0; padding: 10px 18px; border-radius: 8px; cursor: pointer; }
        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; }
        .alert-success { background: #dcfce7; color: #166534; }
        .alert-error { background: #fee2e2; color: #991b1b; }
        .alert ul { margin: 0; padding-left: 20px; }
        .media-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 16px; }
        .media-card { background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.1); }
        .media-card img { width: 100%; height: 160px; object-fit: cover; display: block; }
        .media-card .body { padding: 12px; }
        .media-card h3 { margin: 0 0 4px; font-size: 16px; }
        .media-card p { margin: 0 0 8px; font-size: 13px; color: #64748b; }
    </style>
</head>
<body>
    <header>
        <a href="{{ route('admin.media.index') }}">{{ config('app.name') }} · Panel</a>
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