@extends('emails.layout')

@section('title', 'Hemos recibido tu mensaje')

@section('content')
    <h2 style="margin-top:0;">Hola, {{ $name }}</h2>
    <p>Gracias por escribirnos. Recibimos tu mensaje y te responderemos lo antes posible.</p>

    <p><strong>Copia de tu mensaje:</strong></p>
    <div style="background:#f4f6f8;padding:20px;border-radius:8px;">
        {!! nl2br(e($body)) !!}
    </div>
@endsection

@section('footer', 'Recibiste este correo porque enviaste un mensaje desde nuestro sitio web. Si no fuiste tú, ignóralo.')