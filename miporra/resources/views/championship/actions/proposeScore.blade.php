@extends('pages.layout')

@section('content')
    <div class="jumbotron">
      <h1>Reporting a score:</h1>
    </div>
    <div class="alert alert-info" role="alert">
      <ul>
        <li>This score will be populated to the match only if 3 players more approve it.</li>
      </ul>
    </div>

            @foreach($proposedScores as $proposition)
                <div class="panel panel-default">
                      <div class="panel-heading">Proposed score</div>
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
            @endforeach
    <div class="panel panel-default">
      <div class="panel-heading">Proposed a different one</div>
      <div class="panel-body">
            <form class="form-inline" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                        <label for="local">
                            {!!FlagIcon::get($match->local->short_code,$match->local->name)!!} {{$match->local->name}}
                        </label>
                        <input type="text" class="form-control" id="local" name="local" placeholder="Score...">
                      </div>
                      <div class="form-group">                
                        <input type="text" class="form-control" id="away" name="away" placeholder="Score...">
                        <label for="away">
                            {!!FlagIcon::get($match->away->short_code,$match->away->name)!!} {{$match->away->name}}
                        </label>
                        <button type="submit" class="btn btn-default">Report</button>
                </div>
            </form>
    </div>
</div>
@stop