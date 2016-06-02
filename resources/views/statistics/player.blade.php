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

    <div class="panel panel-default">
          <div class="panel-heading">{{trans('messages.Bets')}}:</div>
          <div class="panel-body">
          <ul class="list-group">
            @foreach($coupons as $coupon)
            <li class="list-group-item"><a href="/coupon/view/{{$coupon->user->id}}">{{$coupon->user->name}}</a></li>
            @endforeach
          </ul>
    </div>

@stop