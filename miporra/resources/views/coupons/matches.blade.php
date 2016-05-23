<div class="page-header">
    <h1>Players</h1>
</div>
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
                <td>
                    {!! 
                        $matchBet->isFilled() ? 
                            $matchBet->prediction : 
                            '<span class="label label-danger">Pending</span>'
                    !!}
                </td>
            </tr>
      @endforeach
  </tbody>
</table> 
<a class="btn btn-primary btn-lg pull-right" href="{{ Url::get('/coupon/matches/update') }}" role="button">
            Change your matches
</a>
