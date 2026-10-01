@extends('layouts.admin')

@section('title', 'Nueva Noticia')

@section('content')
    <div class="page-head">
        <h1>Redactar Noticia</h1>
        <a href="{{ route('admin.news.index') }}" class="btn btn-outline btn-sm">← Volver al listado</a>
    </div>

    <section class="form-card">
        <form action="{{ route('admin.news.store') }}" method="POST">
            @csrf
            @include('admin.news._form', ['news' => null])
        </form>
    </section>
@endsection