@extends('pages.layout')

@section('content')
    <div class="jumbotron">
      <h1>{{trans('messages.Reporting a score:')}}</h1>
    </div>
    <div class="alert alert-info" role="alert">
      <ul>
        <li>{{trans('messages.This score will be populated to the match only if 3 players more approve it.')}}</li>
      </ul>
    </div>

            @foreach($proposedScores as $proposition)
                <div class=" col-md-3">
                    <div class="panel panel-default">
                          <div class="panel-heading">{{trans('messages.Proposed score')}} {{$proposition->times}} {{trans('messages.times')}}</div>
                          <div class="panel-body">{{ $proposition->local_score }} - {{ $proposition->away_score }}</div>
                          <div class="panel-footer">
                                  <form class="form-inline" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" class="form-control" id="local" name="local" value="{{$proposition->local_score}}"> 
                                        <input type="hidden" class="form-control" id="away" name="away" value="{{$proposition->away_score}}">
                                        <button type="submit" class="btn btn-default">Validate</button>
                                    </form>
                          </div>
                    </div>
                </div>
            @endforeach
    <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">{{trans('messages.Proposed a different one')}}</div>
          <div class="panel-body">
                <div class="alert alert-info" role="alert">
                    <ul>
                      <li>{{trans('messages.Add the number of goals scored by each player.')}}</li>
                      <li>{{trans('messages.Leave all of them empty for 0-0')}}</li>
                    </ul>
                </div>
                <form class="form-inline" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group col-xs-12 col-md-12">
                           <div class="col-xs-12 col-md-6">
                                @include('championship.utils.team',['team' => $match->local])
                                <div class="players col-xs-12 col-md-12">
                                    @include('championship.actions.proposeScore.players',['players' => $match->local->players])
                                </div>
                           </div>
                            <div class="col-xs-12 col-md-6">
                                @include('championship.utils.team',['team' => $match->away])
                                <div class="players col-xs-12 col-md-12">
                                    @include('championship.actions.proposeScore.players',['players' => $match->away->players])
                                </div>
                           </div>
                            <button type="submit" class="btn btn-default">{{trans('messages.Report')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop