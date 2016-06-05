@extends('pages.layout')

@section('content')
    <div class="page-header">
      <h1>{{trans('messages.Statistics of match')}}: 
        {!!FlagIcon::get($match->local->short_code,$match->local->name)!!} {{ trans('teams.'.$match->local->name) }}
        {!!FlagIcon::get($match->away->short_code,$match->away->name)!!} {{ trans('teams.'.$match->away->name) }}
        <small>{{$match->date}}</small>
      </h1>
    </div>     
    @include('statistics.match.prediction',['prediction'=> $predictionsWith1, 'predictionValue' => 1])
    @include('statistics.match.prediction',['prediction'=> $predictionsWithX, 'predictionValue' => 'X'])
    @include('statistics.match.prediction',['prediction'=> $predictionsWith2, 'predictionValue' => 2])
@stop