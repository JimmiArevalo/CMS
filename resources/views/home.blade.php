@extends('layouts.public')

@section('title', 'Inicio')

@section('content')
    <h1>Noticias</h1>

    @forelse ($news as $item)
        <article class="news-card">
            @if ($item->media)
                <img src="{{ $item->media->url }}" alt="{{ $item->title }}">
            @endif

            <div class="news-body">
                <h2>{{ $item->title }}</h2>

                @if ($item->excerpt)
                    <p class="lead">{{ $item->excerpt }}</p>
                @endif

                <div>{!! nl2br(e($item->content)) !!}</div>

                <p class="muted">Publicado el {{ $item->created_at->format('d/m/Y') }}</p>
            </div>
        </article>
    @empty
        <p>Todavía no hay noticias publicadas.</p>
    @endforelse
@endsection