@extends('pages.layout')

@section('content')
    <div class="page-header">
        <h1>
            {{trans('messages.Statistics')}} - {{trans('messages.Round')}} {{trans('messages.'.$round->name)}}
        </h1>
    </div>
    <table class="table table-responsive table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('messages.Team') }}</th>
                    <th>{{ trans('messages.Picked on % of bets') }}</th>
                </tr>
            </thead>
            <tbody>
               <?php $i = 1; ?>
              @foreach($teamOnRounds as $key => $breakDownTeamOnRound)
                    <tr>
                        <th scope="row">{{ $i++ }}</th>
                        <td>
                            <a href="/statistics/team/{{$breakDownTeamOnRound->team->id}}">
                                @include('championship.utils.team',['team' => $breakDownTeamOnRound->team])
                            </a>
                        </td>
                        <td>{{round($breakDownTeamOnRound->percentage, 2)}}%</td>  
                    </tr>
              @endforeach
            </tbody>
    </table>  
@stop