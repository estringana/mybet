<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#bets" href="#matches" aria-expanded="false" aria-controls="matches">Matches on first stage</a>
        </h4>   
    </div>
    <div class="panel-body collapse" id="matches">
        <table class="table table-responsive table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Local</th>
                    <th>Away</th>
                    <th>Bet</th>
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
                    Change your matches
        </a>
    </div>
</div>