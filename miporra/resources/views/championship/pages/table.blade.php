@extends('pages.layout')

@section('content')
    <div class="jumbotron">
      <h1>{{trans('messages.Table of')}} {{$championship->name}}</h1>
    </div>
    @include('championship.table.table')
@stop