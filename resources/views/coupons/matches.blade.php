<div class="panel panel-default {{($editable?'editable':'')}}">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a role="button" data-toggle="{{$collapsable or ''}}" data-parent="#bets" href="#matches" aria-expanded="false" aria-controls="matches">{{ trans('messages.Matchesonfirststage') }}</a>
        </h4>   
    </div>
    <div class="panel-body {{$collapsable or ''}}" id="matches">
        @if (isset($editable) && $editable == true)
            <a class="btn btn-primary btn-lg pull-right" href="{{ Url::get('/coupon/matches/update') }}" role="button">
                {{ trans('messages.Changeyourmatches') }}
            </a>
        @endif
        <table class="table table-responsive table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('messages.date') }}</th>
                    <th>{{ trans('messages.local') }}</th>
                    <th>{{ trans('messages.away') }}</th>
                    <th>{{ trans('messages.bet') }}</th>
                    <th>{{ trans('messages.result') }}</th>
                </tr>
            </thead>
            <tbody>
              @foreach($matchBets as $key => $matchBet)
                    @if ($matchBet->match->isPlayed())
                            <tr class="{{$matchBet->getPointsAttribute() == 1 ? 'success':'danger'}}">
                    @else
                            <tr>
                    @endif
                        <th scope="row">{{ $key+1 }}</th>
                        <td>{{ $matchBet->match->date }}</td>
                        <td>{!!FlagIcon::get($matchBet->match->local->short_code,$matchBet->match->local->name)!!} {{ trans('teams.'.$matchBet->match->local->name) }}</td>
                        <td>{{ trans('teams.'.$matchBet->match->away->name) }} {!!FlagIcon::get($matchBet->match->away->short_code,$matchBet->match->away->name)!!}</td>
                        <td class="bet">
                            {!! 
                                $matchBet->isFilled() ? 
                                    $matchBet->prediction : 
                                    '<span class="pending-bet label label-danger">'.trans('messages.Pending').'</span>'
                            !!}
                        </td>
                        <td>{{$matchBet->match->get1X2(false)}}</td>
                    </tr>
              @endforeach
          </tbody>
        </table> 
        @if (isset($editable) && $editable == true)
            <a class="btn btn-primary btn-lg pull-right" href="{{ Url::get('/coupon/matches/update') }}" role="button">                    
                        {{ trans('messages.Changeyourmatches') }}
            </a>
        @endif
    </div>
</div>