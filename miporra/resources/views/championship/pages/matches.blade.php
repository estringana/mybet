@extends('pages.layout')

@section('content')
    <div class="jumbotron">
      <h1>Matches</h1>
    </div>
    @foreach($matchesGropedByRoundName as $roundName => $matches)
        <div class="page-header">
          <h1>{{$roundName}}</h1>
        </div>
        @include('championship.pages.matches.match', [ 'matches' => $matches])
    @endforeach
@stop