@extends('skeleton.page')

@section('body')
    @include('skeleton.menu')
        <div class="container">
            @yield('content')
        </div>
@stop