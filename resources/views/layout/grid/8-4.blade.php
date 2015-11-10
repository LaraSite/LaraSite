@extends('layout.app')

@section('grid')
<div class="row">
    <div class="col-sm-8">
        @section('content')
            Display content here.
        @show
    </div>

    <div class="col-sm-4">
        @section('sidebar')
            Display sidebar here.
        @show
    </div>
</div>
@endsection

