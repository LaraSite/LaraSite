@extends('layout.app')

@section('bodyId', 'contact')

@section('top')
    @include('shared._page_header', [
        'title' => 'Contact',
    ])
@endsection

@section('content')
    @include('shared._errors')

    {!! BootForm::open()->post()->action('mailform') !!}
        @include('shared._mailform_base_elements', [
            '_mailform_subject' => '[LaraSite] Contact',
        ])

        {!! BootForm::text(trans('attributes.contact.subject'), 'subject', old('subject'))->required() !!}
        {!! BootForm::textarea(trans('attributes.contact.body'), 'body', old('body'))->required() !!}

        {!! BootForm::submit(trans('button.submit'), 'btn-primary') !!}
    {!! BootForm::close() !!}
@endsection

@section('script')
    @parent
    @include('shared._confirm_move', ['message' => trans('message.confirm_move_contact')])
@endsection
