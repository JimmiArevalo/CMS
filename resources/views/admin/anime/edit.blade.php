@extends('layouts.admin')

@section('title', 'Editar Anime')

@section('content')
    <div class="page-head">
        <h1>Editar: {{ $anime->title }}</h1>
        <a href="{{ route('admin.anime.index') }}" class="btn btn-outline btn-sm">← Volver al listado</a>
    </div>

    <section class="form-card">
        <form action="{{ route('admin.anime.update', $anime) }}" method="POST">
            @method('PUT')
            @include('admin.anime._form')
        </form>
    </section>
@endsection
