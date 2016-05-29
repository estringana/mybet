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
      @include('coupons.groupedBets', [ 'collapsable' => 'collapse' ])
    </div>
@stop