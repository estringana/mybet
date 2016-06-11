@extends('pages.layout')

@section('content')
    <div class="page-header">
      <h1>{{trans('messages.Statistics - Players')}}</h1>
    </div>
    <table class="table table-responsive table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('messages.Player') }}</th>
                    <th>{{ trans('messages.Picked on % of bets') }}</th>
                    <th>{{ trans('messages.Goals') }}</th>
                </tr>
            </thead>
            <tbody>
               <?php $i = 1; ?>
              @foreach($players as $key => $playerBreakDown)
                    <tr>
                        <th scope="row">{{ $i++ }}</th>
                        <td><a href="/statistics/player/{{$playerBreakDown->player->id}}">{{ $playerBreakDown->player->name }}</a></td>
                        <td>{{round($playerBreakDown->percentage, 2)}}%</td>  
                        <td>{{$playerBreakDown->player->countable_goals}}</td>
                    </tr>
              @endforeach
            </tbody>
    </table>  
@stop