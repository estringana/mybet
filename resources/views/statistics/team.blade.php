@extends('pages.layout')

@section('content')
    <div class="page-header">
      <h1>{{trans('messages.Statistics of team')}} {!!FlagIcon::get($team->short_code,$team->name)!!} {{ trans('teams.'.$team->name) }}</h1>
    </div>

    @foreach($teamOnRounds as $breakDownRound)
         <div class="page-header">
           <h2>{{trans('messages.'.$breakDownRound->round->name)}}</h2>
        </div>
        <div class="panel panel-default">
              <div class="panel-body">
                    <p>{{trans('messages.This team is on')}} {{round($breakDownRound->percentage,2)}}% {{trans('messages.of the bets on this round')}}</p>                
                </div>
        </div>
        @if($breakDownRound->coupons->count() > 0 )
            <div class="panel panel-default {{$breakDownRound->round->identifier}}title">
                <div class="panel-heading">
                     <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent=".{{$breakDownRound->round->identifier}}title" href=".{{$breakDownRound->round->identifier}}bets" aria-expanded="false" aria-controls="{{$breakDownRound->round->identifier}}bets">
                                {{trans('messages.Bets')}}:
                              </a>
                    </h4>
                </div>
                <div class="panel-collapse collapse {{$breakDownRound->round->identifier}}bets" role="tabpanel" aria-labelledby="{{$breakDownRound->round->identifier}}title">
                        <div class="panel-body">
                                  <ul class="list-group">
                                    @foreach($breakDownRound->coupons as $coupon)
                                    <li class="list-group-item"><a href="/coupon/view/{{$coupon->user->id}}">{{$coupon->user->name}}</a></li>
                                    @endforeach
                                  </ul>
                        </div>
                </div>
            </div>
        @endif
    @endforeach
@stop