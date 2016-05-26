@extends('pages.layout')

@section('content')
    <div class="jumbotron">
      <h1>Table of {{$championship->name}}</h1>
    </div>
    @include('championship.table.table')
@stop