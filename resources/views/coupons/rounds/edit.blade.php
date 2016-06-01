@extends('pages.layout')

@section('content')
<div class="jumbotron">
  <h1>{{trans('messages.Create your bet')}} - {{trans('messages.Round')}} {{trans('messages.'.$title)}}</h1>
</div>
<div class="alert alert-info" role="alert">
  <ul>
    <li>{{trans('messages.You can pick whatever team you want to. It does not need to be on your previous round')}}</li>
  </ul>
</div>


<form class="form-horizontal" method="POST" action="{{Url::get('/coupon/round/store')}}">
  {{ csrf_field() }}
    @foreach($roundBets as $roundBet)
        <div class="form-group">
          <select class="form-control selectpicker" name="bet[{{$roundBet->id}}]" data-live-search="true">
                <option value="">{{trans('messages.Pick a team')}}</option>
                @foreach ($teams as $team)
                    <option
                            value="{{ $team->id }}" 
                            {{old('bet['.$roundBet->id.']') == $team->id ? 'selected' : ''}}
                            {{ old('bet['.$roundBet->id.']') == null && ! $errors->has('bet['.$roundBet->id.']') && $roundBet->isFilled() && $roundBet->team->id == $team->id ? 'selected' : ''}}>
                        {{trans('teams.'.$team->name)}}
                    </option>
                @endforeach
            </select>
        </div>  
    @endforeach

    <div class="form-group">
      <button type="submit" class="btn btn-primary pull-right">{{trans('messages.Save teams') }}</button>
    </div>
</form>
@stop