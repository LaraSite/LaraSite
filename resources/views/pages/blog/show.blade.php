@extends('layout.grid.8-4')

@section('bodyId', 'blogShow')

@section('top')
    @include('shared._page_header', [
        'title' => 'Blog',
    ])
@endsection

@section('sidebar')
    <p><img class="img-responsive img-thumbnail" src="/img/placeholder/300x100.gif" alt="placeholder"></p>
    <p><img class="img-responsive img-thumbnail" src="/img/placeholder/300x100.gif" alt="placeholder"></p>
    <p><img class="img-responsive img-thumbnail" src="/img/placeholder/300x100.gif" alt="placeholder"></p>
    <p><img class="img-responsive img-thumbnail" src="/img/placeholder/300x100.gif" alt="placeholder"></p>
@endsection

@section('content')
    <article>
        <h3>{{ $article->title }}</h3>
        <p>{!! $article->body !!}</p>
        <div class="blogMeta">
            {{ $article->meta_info }}
            <span class="pull-right">
                {{ $article->published_at->format('Y-m-d') }}
            </span>
        </div>
        <div class="clearfix"></div>
    </article>
@endsection
