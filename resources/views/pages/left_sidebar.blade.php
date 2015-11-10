@extends('layout.grid.3-9')

@section('bodyId', 'leftSidebar')

@section('top')
    @include('shared._page_header', [
        'title' => 'Left Sidebar',
        'lead' => 'Sample for left sidebar',
    ])
@endsection

@section('sidebar')
<p><img class="img-responsive img-thumbnail" src="/img/placeholder/300x100.gif" alt="placeholder"></p>
<p><img class="img-responsive img-thumbnail" src="/img/placeholder/300x100.gif" alt="placeholder"></p>
<p><img class="img-responsive img-thumbnail" src="/img/placeholder/300x100.gif" alt="placeholder"></p>
<p><img class="img-responsive img-thumbnail" src="/img/placeholder/300x100.gif" alt="placeholder"></p>
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

