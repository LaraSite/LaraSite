@extends('layout.app')

@section('bodyId', 'page')

@section('top')
    @include('shared._page_header', [
        'title' => 'Page',
        'lead' => 'Sample page',
    ])
@endsection

@section('content')
<img class="img-responsive" src="/img/placeholder/900x300.gif" alt="placeholder">

<h1>Header1</h1>
<h2>Header2</h2>
<h3>Header3</h3>

<ul>
    <li>List1</li>
    <li>List2</li>
    <li>List3</li>
</ul>
@endsection

