@extends('layouts.admin')

@section('title', 'Crear cuenta')

@section('content')
    <section class="card login-card">
        <h1>Crear cuenta</h1>

        <form action="{{ route('admin.register.attempt') }}" method="POST">
            @csrf

            <label for="name">Nombre completo</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
            >

            <label for="email">Correo electrónico</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                required
            >

            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" required minlength="8">

            <label for="password_confirmation">Confirmar contraseña</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required minlength="8">

            <button type="submit">Registrarme</button>
        </form>

        <p class="muted"><a href="{{ route('admin.media.index') }}">← Volver al panel</a></p>    </section>
@endsection