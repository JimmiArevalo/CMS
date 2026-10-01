@extends('layouts.admin')

@section('title', 'Crear cuenta')

@section('content')
    <section class="card login-card">
        <h1>Crear cuenta</h1>

        <form action="{{ route('register.attempt') }}" method="POST">
            @csrf

            <label for="name">Nombre completo</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
                placeholder="Tu nombre o apodo"
            >

            <label for="email">Correo electrónico</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                required
                placeholder="ejemplo@animeverse.test"
            >

            <label for="password">Contraseña</label>
            <input
                type="password"
                id="password"
                name="password"
                required
                minlength="8"
                placeholder="Mínimo 8 caracteres"
            >

            <label for="password_confirmation">Confirmar contraseña</label>
            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                required
                minlength="8"
                placeholder="Repite tu contraseña"
            >

            <button type="submit">Registrarme</button>
        </form>

        <div style="margin-top: 20px; padding-top: 16px; border-top: 1px solid var(--border); text-align: center;">
            <p style="margin: 0; font-size: 0.9rem; color: var(--muted);">
                ¿Ya tienes una cuenta?
                <a href="{{ route('login') }}" style="color: var(--accent); font-weight: bold; margin-left: 4px;">
                    Inicia sesión aquí
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
@endsection