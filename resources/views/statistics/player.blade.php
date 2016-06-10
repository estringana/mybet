@extends('pages.layout')

@section('content')
    <div class="page-header">
      <h1>{{trans('messages.Statistics of player')}} {{$player->name}} {!!FlagIcon::get($player->team->short_code,$player->team->name)!!} {{ trans('teams.'.$player->team->name) }}</h1>
    </div>
    <div class="panel panel-default">
          <div class="panel-body">
            <p>{{trans('messages.This player is on')}} {{round($percentage,2)}}% {{trans('messages.of the bets')}}</p>
            <p>{{trans('messages.This players has scored')}} {{$player->countable_goals}} {{trans('messages.goals')}}</p>
            </div>
    </div>

    <div class="panel panel-default playerbetstitle">
          <div class="panel-heading">
              <h4 class="panel-title">
                  <a role="button" data-toggle="collapse" data-parent=".playerbetstitle" href=".playerbets" aria-expanded="false" aria-controls="playerbets">
                  {{trans('messages.Bets')}}:
                </a>
            </h4>
            
          </div>
          <div class="panel-collapse collapse playerbets" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                          <ul class="list-group">
                            @foreach($coupons as $coupon)
                            <li class="list-group-item"><a href="/coupon/view/{{$coupon->user->id}}">{{$coupon->user->name}}</a></li>
                            @endforeach
                          </ul>
                </div>
          </div>
    </div>

@stop