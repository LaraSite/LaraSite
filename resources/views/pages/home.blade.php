@extends('layout.app')

@section('bodyId', 'home')

@section('top')
<header>
    <h1>LaraSite</h1>
    <p class="lead">You can make web site easily with Laravel.</p>
    <a class="btn btn-success btn-lg" href="#">Document</a>
</header>
@endsection

@section('content')
<div class="feature">
    <div class="row">
        <div class="col-sm-4">
            <span class="glyphicon glyphicon-thumbs-up"></span>
            <h2>Laravel</h2>
            <p>Extensible in the Laravel Way.</p>
        </div>
        <div class="col-sm-4">
            <span class="glyphicon glyphicon-indent-left"></span>
            <h2>Bootstrap</h2>
            <p>Flexible design in the Bootstrap Way.</p>
        </div>
        <div class="col-sm-4">
            <span class="glyphicon glyphicon-cog"></span>
            <h2>Simple Admin</h2>
            <p>Manage blog and files.</p>
        </div>
    </div><!-- /row -->
</div><!-- /featurette -->
@endsection
