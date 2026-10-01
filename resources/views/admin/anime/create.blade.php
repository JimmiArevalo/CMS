@extends('layouts.admin')

@section('title', 'Nuevo Anime')

@section('content')
    <div class="page-head">
        <h1>Registrar Nuevo Anime</h1>
        <a href="{{ route('admin.anime.index') }}" class="btn btn-outline btn-sm">← Volver al listado</a>
    </div>

    <section class="form-card">
        <form action="{{ route('admin.anime.store') }}" method="POST">
            @include('admin.anime._form')
        </form>
    </section>
@endsection
