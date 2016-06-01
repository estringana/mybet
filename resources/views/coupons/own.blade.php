@extends('pages.layout')

@section('content')
        <div class="jumbotron">
      <h1>{{ trans('messages.yourbet') }}</h1>
      <p>
        {{ trans('messages.Thisisyourbet')}}. {{ trans('messages.Besureyoufinishitbeforetheenddate') }}.
        {{ trans('messages.The end date and time is:')}} <b>{{$championship->end_inscription}}</b>
      </p>
      <p>
            <i>{{ trans('messages.progressofyourbet') }}</i>
                @include('coupons.progress') 
       </p>
       <p>
            {{ trans('messages.The status of your bet is:') }}
            @if ($user->has_paid)
                <span class="label label-success">{{trans('messages.Paid')}}</span>
            @else
                <span class="label label-danger">{{trans('messages.Not paid')}}</span>
            @endif
       </p>
    </div>
    <div class="panel-group" id="bets" role="tablist" aria-multiselectable="true">
      @include('coupons.groupedBets', [ 'collapsable' => 'collapse' ])
    </div>
@stop