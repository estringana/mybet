@extends('pages.layout')

@section('content')
    @foreach($rounds as $round)
        @if($round->teams->count() > 0)
            <div class="page-header">
              <h1>{{trans('messages.'.$round->name)}}</h1>
            </div>
            <p>{{trans('messages.Teams on round')}}</p>
            @include('championship.pages.rounds.teams',['teams' => $round->teams])
        @endif
    @endforeach
@stop