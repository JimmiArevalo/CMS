@extends('layouts.admin')

@section('title', 'Editar noticia')

@section('content')
    <h1>Editar noticia</h1>

    <section class="card">
        <form action="{{ route('admin.news.update', $news) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.news._form', ['news' => $news])

            <button type="submit">Guardar cambios</button>
        </form>
    </section>
@endsection