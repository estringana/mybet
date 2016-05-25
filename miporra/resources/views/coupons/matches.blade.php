<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#bets" href="#matches" aria-expanded="false" aria-controls="matches">{{ trans('messages.Matchesonfirststage') }}</a>
        </h4>   
    </div>
    <div class="panel-body collapse" id="matches">
        <table class="table table-responsive table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('messages.date') }}</th>
                    <th>{{ trans('messages.local') }}</th>
                    <th>{{ trans('messages.away') }}</th>
                    <th>{{ trans('messages.bet') }}</th>
                </tr>
            </thead>
            <tbody>
              @foreach($matchBets as $key => $matchBet)
                    <tr>
                        <th scope="row">{{ $key }}</th>
                        <td>{{ $matchBet->match->date }}</td>
                        <td>{{ $matchBet->match->local->name }}</td>
                        <td>{{ $matchBet->match->away->name }}</td>
                        <td class="bet">
                            {!! 
                                $matchBet->isFilled() ? 
                                    $matchBet->prediction : 
                                    '<span class="pending-bet label label-danger">Pending</span>'
                            !!}
                        </td>
                    </tr>
              @endforeach
          </tbody>
        </table> 
        <a class="btn btn-primary btn-lg pull-right" href="{{ Url::get('/coupon/matches/update') }}" role="button">                    
                    {{ trans('messages.Changeyourmatches') }}
        </a>
    </div>
</div>