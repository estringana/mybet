@extends('pages.layout')

@section('content')
    <div class="jumbotron">
      <h1>{{trans('messages.matches')}}</h1>
    </div>
    @foreach($matchesGropedByRoundName as $roundName => $matches)
        <div class="page-header">
          <h1>{{trans('messages.'.$roundName)}}</h1>
        </div>
        @include('championship.pages.matches.match', [ 'matches' => $matches])
    @endforeach
@stop