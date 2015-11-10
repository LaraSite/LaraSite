@extends('admin.layout.blog')

@section('bodyId', 'adminArticlesCreate')

@section('content')
    <h1 class="title">{{ trans('title.new_article') }}</h1>

    @include('shared._errors')

    {!! BootForm::open()->action(route('admin.articles.store')) !!}
        @include('admin.articles._form')
        {!! BootForm::submit(trans('button.add'), 'btn-primary') !!}
    {!! BootForm::close() !!}
@endsection

@section('script')
    @parent
    @include('admin.shared._tinymce')
    @include('admin.shared._datetimepicker')
    @include('admin.shared._select2')
    @include('shared._confirm_move', ['message' => trans('message.confirm_move_article')])
@endsection
