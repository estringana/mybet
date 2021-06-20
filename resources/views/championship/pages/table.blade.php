@extends('pages.layout')

@section('content')
    <div class="jumbotron">
      <h1>{{trans('messages.Table of')}} {{$championship->name}}</h1>
    </div>
    <div class="alert alert-info" role="alert">
        {{trans('messages.We have started counting points from qualified teams. Check on the next link')}}:
        <a href="/rounds">{{trans('messages.Qualified teams')}}</a>
    </div>
    @include('championship.table.table')
@stop