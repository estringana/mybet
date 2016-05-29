@extends('pages.layout')

@section('content')
    @foreach($coupons as $coupon)
        <div class="jumbotron">
                <h1>Bets of {{ $coupon['user']->name }}</h1>      
        </div>
        <div class="panel-group" id="bets" role="tablist" aria-multiselectable="true">
              @include('coupons.groupedBets', [extract($coupon)])
        </div>
    @endforeach
@stop