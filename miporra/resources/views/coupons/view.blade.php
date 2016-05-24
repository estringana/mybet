@extends('pages.layout')

@section('content')
        <div class="jumbotron">
      <h1>Your bet</h1>
      <p>This is your bet. Be sure you finish it before the end date.</p>
      <p>
            <i>Progress of your bet</i>
                @include('coupons.progress') 
       </p>
    </div>
    <div class="panel-group" id="bets" role="tablist" aria-multiselectable="true">
      @include('coupons.players')
      @include('coupons.matches')
    </div>
@stop