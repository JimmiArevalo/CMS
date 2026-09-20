@extends('emails.layout')

@section('title', 'Nuevo mensaje de contacto')

@section('content')
    <h2 style="margin-top:0;">Nuevo mensaje de contacto</h2>
    <p>Se ha recibido un nuevo mensaje desde el sitio web.</p>
    <hr style="border:0;border-top:1px solid #e2e8f0;">

    <p><strong>Nombre:</strong> {{ $name }}</p>
    <p><strong>Correo:</strong> {{ $email }}</p>
    <p><strong>Mensaje:</strong></p>

    <div style="background:#f4f6f8;padding:20px;border-radius:8px;">
        {!! nl2br(e($body)) !!}
    </div>

    <p style="font-size:13px;color:#666666;">
        Puedes responder a este correo: la respuesta llegará a {{ $email }}.
    </p>
@endsection