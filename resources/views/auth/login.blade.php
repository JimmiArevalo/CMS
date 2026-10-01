@extends('layouts.admin')

@section('title', 'Iniciar sesión')

@section('content')
    <section class="card login-card">
        <h1>Iniciar sesión</h1>

        <form action="{{ route('login.attempt') }}" method="POST">
            @csrf

            <label for="email">Correo electrónico</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
            >

            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Entrar</button>
        </form>

        <div style="margin-top: 20px; padding-top: 16px; border-top: 1px solid var(--border); text-align: center;">
            <p style="margin: 0; font-size: 0.9rem; color: var(--muted);">
                ¿No tienes una cuenta?
                <a href="{{ route('register') }}" style="color: var(--accent); font-weight: bold; margin-left: 4px;">
                    Regístrate aquí
                </a>
            </p>
        </div>

        <div style="margin-top: 12px; text-align: center;">
            <a href="{{ route('home') }}" class="muted" style="font-size: 0.85rem;">
                ← Volver al portal público
            </a>
        </div>
    </section>
@endsection