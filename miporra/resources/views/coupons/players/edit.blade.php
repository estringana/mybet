@extends('pages.layout')

@section('content')
<div class="jumbotron">
  <h1>Create your bet - Players step</h1>
  <p>Pick {{$bets_allowed}} player for your team. Remember that your should be picking player you think they will score</p>
</div>
<div class="alert alert-info" role="alert">
  <ul>
    <li>You must pick 8 players</li>
    <li>You can pick a player more than once</li>
  </ul>
</div>


<form class="form-horizontal" method="POST" action="store">
  {{ csrf_field() }}
    @for ($i = 0; $i < $bets_allowed; $i++)
        <div class="form-group {{ $errors->has('player_'.$i) ? ' has-error' : '' }}">
          <select class="form-control selectpicker" name="player_{{$i}}" data-live-search="true">                
                <option value="">Pick a player...</option>
                @foreach ($players as $player)
                    <option data-subtext="{{ $player->team->name }}" 
                            value="{{ $player->id }}" 
                            {{old('player_'.$i) == $player->id ? 'selected' : ''}}
                            {{ old('player_'.$i) == null && ! $errors->has('player_'.$i) && isset($selected_players[$i]) && $selected_players[$i] == $player->id ? 'selected' : ''}}>
                        {{$player->name}}
                    </option>
                @endforeach
            </select>
        </div>  
    @endfor

    <div class="form-group">
      <button type="submit" class="btn btn-primary pull-right">Next step</button>
    </div>
</form>
@stop