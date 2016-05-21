@extends('pages.layout')

@section('content')
<div class="jumbotron">
  <h1>Create your bet - Players step</h1>
  <p>Pick {{$bets_allowed}} player for your team. Remember that your should be picking player you think they will score</p>
</div>
<form class="form-horizontal" method="POST" action="store">
  {{ csrf_field() }}
    @for ($i = 0; $i < $bets_allowed; $i++)
        <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Player {{$i+1}}:</label>
        <div class="col-sm-10">
          <select class="form-control selectpicker" name="player[{{$i}}]" data-live-search="true">                
                @foreach ($players as $player)
                    <option data-subtext="{{ $player->team->name }}" value="{{ $player->id }}">{{$player->name}}</option>
                @endforeach
            </select>
            </div>
        </div>  
    @endfor

    <div class="form-group">
      <button type="submit" class="btn btn-primary pull-right">Next step</button>
    </div>
</form>
@stop