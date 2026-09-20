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
    </section>
@endsection