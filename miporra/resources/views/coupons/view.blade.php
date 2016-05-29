@extends('pages.layout')

@section('content')
    <div class="jumbotron">
            <h1>Bets of {{ $user->name }}</h1>      
    </div>
    <div class="panel-group" id="bets" role="tablist" aria-multiselectable="true">
      @include('coupons.groupedBets')
    </div>
@stop