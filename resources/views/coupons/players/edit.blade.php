@extends('pages.layout')

@section('content')
<div class="jumbotron">
  <h1>{{trans('messages.Create your bet')}} - {{trans('messages.Players step')}}</h1>
  <p>{{trans('messages.Pick the players for your bet. Remember that your should be picking player you think they will score')}}</p>
</div>
<div class="alert alert-info" role="alert">
  <ul>
    <li>{{trans('messages.You must pick 8 players')}}</li>
    <li>{{trans('messages.You can not pick a player twice')}}</li>
  </ul>
</div>
<div class="alert alert-warning" role="alert">
  <p>{{trans('messages.not_confirmed_players')}}</p>
</div>


<form class="form-horizontal" method="POST" action="store">
  {{ csrf_field() }}
    @foreach($playerBets as $playerBet)
        <div class="form-group">
          <select class="form-control selectpicker" name="bet[{{$playerBet->id}}]" data-live-search="true">
                <option value="">{{trans('messages.Pick a player')}}</option>
                @foreach ($players as $player)
                    <option data-subtext="{{ trans('teams.'.$player->team->name) }}" 
                            value="{{ $player->id }}" 
                            {{old('bet['.$playerBet->id.']') == $player->id ? 'selected' : ''}}
                            {{ old('bet['.$playerBet->id.']') == null && ! $errors->has('bet['.$playerBet->id.']') && $playerBet->isFilled() && $playerBet->player->id == $player->id ? 'selected' : ''}}>
                        {{$player->name}}
                    </option>
                @endforeach
            </select>
        </div>  
    @endforeach

    <div class="form-group">
      <button type="submit" class="btn btn-primary pull-right">{{trans('messages.Save players')}}</button>
    </div>
</form>
@stop