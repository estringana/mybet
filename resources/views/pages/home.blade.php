@extends('pages.layout')

@section('content')
     <div class="jumbotron">
       <h1>{{ trans('messages.title') }}</h1>
            <p>{{ trans('messages.Everything has been released now') }}</p>
            <p>{{ trans('messages.all_released') }}</p>
            <p>{{ trans('messages.final_released') }}</p>
            <a class="btn btn-primary btn-lg" href="https://we.tl/W16Bz4xpro" role="button">
                {{ trans('messages.Download the PDF from here') }}
            </a> 
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