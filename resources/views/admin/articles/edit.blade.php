@extends('admin.layout.blog')

@section('bodyId', 'adminArticlesEdit')

@section('content')
    <h1 class="title">{{ trans('title.edit_article') }}</h1>

    @include('shared._errors')

    {!! BootForm::open()->put()->action(route('admin.articles.update', ['id' => $article->id])) !!}
        @include('admin.articles._form')
        {!! BootForm::submit(trans('button.update'), 'btn-primary') !!}
    {!! BootForm::close() !!}
@endsection

@section('script')
    @parent
    @include('admin.shared._tinymce')
    @include('admin.shared._datetimepicker')
    @include('admin.shared._select2')
    @include('shared._confirm_move', ['message' => trans('message.confirm_move_article')])
@endsection
