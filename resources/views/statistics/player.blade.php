@extends('pages.layout')

@section('content')
    <div class="panel panel-default">
          <div class="panel-heading">{{trans('messages.Statistics of player')}} {{$player->name}} {!!FlagIcon::get($player->team->short_code,$player->team->name)!!} {{ trans('teams.'.$player->team->name) }}</div>
          <div class="panel-body">
            <p>{{trans('messages.This player is on')}} {{$percentage}}% {{trans('messages.of the bets')}}</p>
            <p>{{trans('messages.This players has scored')}} {{$player->countable_goals}} {{trans('messages.goals')}}</p>
            <p><b>{{trans('messages.Bets')}}:</b></p>
          </div>
          <ul class="list-group">
            @foreach($coupons as $coupon)
            <li class="list-group-item"><a href="/coupon/view/{{$coupon->user->id}}">{{$coupon->user->name}}</a></li>
            @endforeach
          </ul>
    </div>

@stop