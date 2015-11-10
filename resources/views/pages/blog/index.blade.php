@extends('layout.grid.8-4')

@section('bodyId', 'blog')

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
    @if (count($articles) <= 0)
        <p>{{ trans('message.entity_not_exist', ['entity' => trans('models.article')]) }}</p>
        <div class="spacer20"></div>
    @else
        @foreach($articles as $article)
            <article>
                <h3>
                    <a href="/blog/{{ $article->id }}">
                        {{ $article->title }}
                    </a>
                </h3>
                <div>
                    {!! $article->summary !!}
                </div>
                <div class="blogMeta">
                    {{ $article->meta_info }}
                    <span class="pull-right">
                        {{ $article->published_at->format('Y-m-d') }}
                    </span>
                </div>
                <div class="clearfix"></div>
            </article>
            <hr/>
        @endforeach

        <div class="text-center">
            @include('shared._pager', [
                'pagination' => $articles,
            ])
        </div>
    @endif
@endsection
