@extends('layouts.admin')

@section('title', 'Nueva noticia')

@section('content')
    <h1>Nueva noticia</h1>

    <section class="card">
        <form action="{{ route('admin.news.store') }}" method="POST">
            @csrf

            @include('admin.news._form', ['news' => null])

            <button type="submit">Guardar noticia</button>
        </form>
    </section>
@endsection