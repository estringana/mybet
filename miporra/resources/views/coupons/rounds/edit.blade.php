@extends('pages.layout')

@section('content')
<div class="jumbotron">
  <h1>Create your bet - Round {{$title}}</h1>
  <p>To be filled</p>
</div>
<div class="alert alert-info" role="alert">
  <ul>
    <li>You can pick whatever team you want to. It does not need to be on your previous round</li>
  </ul>
</div>


<form class="form-horizontal" method="POST" action="{{Url::get('/coupon/round/store')}}">
  {{ csrf_field() }}
    @foreach($roundBets as $roundBet)
        <div class="form-group">
          <select class="form-control selectpicker" name="bet[{{$roundBet->id}}]" data-live-search="true">
                <option value="">Pick a team...</option>
                @foreach ($teams as $team)
                    <option
                            value="{{ $team->id }}" 
                            {{old('bet['.$roundBet->id.']') == $team->id ? 'selected' : ''}}
                            {{ old('bet['.$roundBet->id.']') == null && ! $errors->has('bet['.$roundBet->id.']') && $roundBet->isFilled() && $roundBet->team->id == $team->id ? 'selected' : ''}}>
                        {{$team->name}}
                    </option>
                @endforeach
            </select>
        </div>  
    @endforeach

    <div class="form-group">
      <button type="submit" class="btn btn-primary pull-right">Save teams</button>
    </div>
</form>
@stop