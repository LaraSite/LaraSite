@extends('layout.app')

@section('grid')
<div class="row">
    <div class="col-sm-2">
        @section('sidebar')
            Display sidebar here.
        @show
    </div>

    <div class="col-sm-10">
        @section('content')
            Display content here.
        @show
    </div>
</div>
@endsection

