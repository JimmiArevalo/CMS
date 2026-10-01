@extends('layouts.admin')

@section('title', 'Editar Noticia')

@section('content')
    <div class="page-head">
        <h1>Editar Noticia: {{ Str::limit($news->title, 40) }}</h1>
        <a href="{{ route('admin.news.index') }}" class="btn btn-outline btn-sm">← Volver al listado</a>
    </div>

    <section class="form-card">
        <form action="{{ route('admin.news.update', $news) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.news._form', ['news' => $news])
        </form>
    </section>
@endsection