@extends('pages.layout')

@section('content')
    <div class="jumbotron">
      <h1>{{ trans('messages.title') }}</h1>
      <p>{{ trans('messages.create_a_team.message') }}</p>
      <p>
        <a class="btn btn-primary btn-lg" href="#" role="button">
            {{ trans('messages.create_a_team.button') }}
        </a>
    </p>
    </div>
@stop