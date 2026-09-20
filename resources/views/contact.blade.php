@extends('layouts.public')

@section('title', 'Contacto')

@section('content')
    <h1>Contacto</h1>

    <section class="card">
        <form action="{{ route('contact.send') }}" method="POST">
            @csrf

            <label for="name">Nombre</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" maxlength="100" required>

            <label for="email">Correo electrónico</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" maxlength="255" required>

            <label for="message">Mensaje</label>
            <textarea id="message" name="message" rows="6" maxlength="5000" required>{{ old('message') }}</textarea>

            <button type="submit">Enviar mensaje</button>
        </form>
    </section>
@endsection