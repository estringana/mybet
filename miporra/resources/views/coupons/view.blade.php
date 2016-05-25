@extends('pages.layout')

@section('content')
        <div class="jumbotron">
      <h1>{{ trans('messages.yourbet') }}</h1>
      <p></p>
      <p>{{ trans('messages.Thisisyourbet')}}{{ trans('messages.Besureyoufinishitbeforetheenddate.') }}
</p>
      <p>
            <i>{{ trans('messages.progressofyourbet') }}</i>
                @include('coupons.progress') 
       </p>
    </div>
    <div class="panel-group" id="bets" role="tablist" aria-multiselectable="true">
      @include('coupons.players')
      @include('coupons.matches')
      @include('coupons.rounds', [ 'bets' => $roundOf16Bets, 'title' => 'Round of 16' ])
      @include('coupons.rounds', [ 'bets' => $quarterFinalsBets, 'title' => 'Quarter finals' ])
      @include('coupons.rounds', [ 'bets' => $semiFinals, 'title' => 'Semi Finals' ])
      @include('coupons.rounds', [ 'bets' => $final, 'title' => 'Final' ])
      @include('coupons.rounds', [ 'bets' => $champion, 'title' => 'Champion' ])
      @include('coupons.rounds', [ 'bets' => $runnersup, 'title' => 'Runners-up' ])
    </div>
@stop