<div class="page-header">
    <h1>Players</h1>
</div>
<table class="table table-responsive table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Team</th>
        </tr>
    </thead>
    <tbody>
      @foreach($playerBets as $key => $bet)
            <tr>
                <th scope="row">{{ $key+1 }}</th>
                <td>{{ $bet->isFilled() ? $bet->player->name : '' }}</td>
                <td class="bet">{!! $bet->isFilled() ? $bet->player->team->name : '<span class="pending-bet label label-danger">Pending</span>' !!}</td>
            </tr>
      @endforeach
  </tbody>
</table> 
<a class="btn btn-primary btn-lg pull-right" href="{{ Url::get('/coupon/players/update') }}" role="button">
            Change your players
</a>
