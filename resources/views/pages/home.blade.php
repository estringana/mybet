@extends('pages.layout')

@section('content')
    <div class="jumbotron">    
      <h1>{{ trans('messages.title') }}</h1>
      <div class="alert alert-info" role="alert">
        {{trans('messages.The time for doing changes has been extended to 9pm(uk time) - 22:00(es time)')}}
    </div>
      @if(Auth::user())
            <p>{{ trans('messages.All you need to do now is to finish your bet') }}</p>
            <a class="btn btn-primary btn-lg" href="{{ Url::get('/coupon') }}" role="button">
                {{ trans('messages.Manage your bet') }}
            </a>
      @else
            <div class="alert alert-info" role="alert">
    </div>
          <p>{{ trans('messages.create_a_team.message') }}</p>
          <p>
            <a class="btn btn-primary btn-lg" href="{{ Url::get('/coupon') }}" role="button">
                {{ trans('messages.create_a_team.button') }}
            </a>
        @endif
    </p>
    </div>
    <div class="page-header">
      <h1>{{trans('messages.Rules')}}</h1>
      <ol>
            <li>{{trans('rules.Payments.title')}}</li>
                <ul>
                    <li>{{trans('rules.Payments.001')}}</li>
                    <li>{{trans('rules.Payments.002')}}</li>
                    <li>{{trans('rules.Payments.003')}}</li>
                    <li>{{trans('rules.Payments.004')}}</li>
                </ul>
            <li>{{trans('rules.Bets.title')}}</li>
                <ul>
                    <li>{{trans('rules.Bets.001')}}</li>
                    <li>{{trans('rules.Bets.002')}}</li>
                    <li>{{trans('rules.Bets.003')}}</li>
                    <li>{{trans('rules.Bets.004')}}</li>
                </ul>
            <li>{{trans('rules.Website.title')}}</li>
                <ul>
                    <li>{{trans('rules.Website.001')}}</li>
                    <li>{{trans('rules.Website.002')}}</li>
                    <li>{{trans('rules.Website.003')}}</li>
                    <li>{{trans('rules.Website.004')}}</li>
                    <li>{{trans('rules.Website.005')}}</li>                    
                </ul>
            <li>{{trans('rules.Prizes.title')}}</li>
                <ul>
                    <li>{{trans('rules.Prizes.001')}}</li>
                    <li>{{trans('rules.Prizes.002')}}</li>
                    <li>{{trans('rules.Prizes.003')}}</li>
                    <li>{{trans('rules.Prizes.004')}}</li>
                    <li>{{trans('rules.Prizes.005')}}</li>
                    <li>{{trans('rules.Prizes.006')}}</li>
                </ul>
            <li>{{trans('rules.Goals.title')}}</li>
                <ul>
                    <li>{{trans('rules.Goals.001')}}</li>
                </ul>
            <li>{{trans('rules.Points.title')}}</li>
                <ul>
                    <li>{{trans('rules.Points.001')}}</li>
                    <li>{{trans('rules.Points.002')}}</li>
                    <li>{{trans('rules.Points.003')}}</li>
                    <li>{{trans('rules.Points.004')}}</li>
                    <li>{{trans('rules.Points.005')}}</li>
                    <li>{{trans('rules.Points.006')}}</li>
                    <li>{{trans('rules.Points.007')}}</li>
                    <li>{{trans('rules.Points.008')}}</li>
                </ul>
            <li>{{trans('rules.Clarifications.title')}}</li>
                <ul>
                    <li>{{trans('rules.Clarifications.001')}}</li>
                    <li>{{trans('rules.Clarifications.002')}}</li>
                </ul>
      </ol>
    </div>
@stop