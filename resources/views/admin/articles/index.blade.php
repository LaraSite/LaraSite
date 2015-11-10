@extends('admin.layout.blog')

@section('bodyId', 'adminArticlesIndex')

@section('content')
<h1 class="title">{{ trans('models.article') }}</h1>

{!! BootForm::open()
    ->delete()
    ->action(route('admin.articles.destroy'))
    ->id('deleteForm') !!}
{!! BootForm::close() !!}

@if (count($articles) <= 0)
    <p>{{ trans('message.entity_not_exist', ['entity' => trans('models.article')]) }}</p>
    <div class="spacer20"></div>
@else
    @include('admin.shared._index_nav', [
        'pagination' => $articles,
        'add_url' => route('admin.articles.create'),
        'delete_form_id' => 'deleteForm',
    ])
    <div class="table-responsive spacer10">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>{{ trans('attributes.article.title') }}</th>
                <th>{{ trans('attributes.article.status') }}</th>
                <th>{{ trans('attributes.article.category') }}</th>
                <th>{{ trans('attributes.article.published') }}</th>
                <th class="text-center deleteColumn">
                    <label><input type="checkbox" id="checkAllDelete"></label>
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($articles as $article)
                <tr>
                    <td>
                        <a href="{{ route('admin.articles.edit', ['id' => $article->id]) }}">{{ $article->title }}</a>
                    </td>
                    <td>{{ $article->status }}</td>
                    <td>{{ $article->category_name }}</td>
                    <td>{{ $article->published_at->format('Y-m-d H:i') }}</td>
                    <td class="text-center">
                        <label><input form="deleteForm" class="checkDelete" type="checkbox" name="delete_items[]" value="{{ $article->id }}"></label>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div><!-- .table-responsive -->
@endif

@include('admin.shared._index_nav', [
    'pagination' => $articles,
    'add_url' => route('admin.articles.create'),
    'delete_form_id' => 'deleteForm',
])

@endsection
