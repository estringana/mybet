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
      @foreach($players as $key => $player)
            <tr>
                <th scope="row">{{ $key }}</th>
                <td>{{ $player->name }}</td>
                <td>{{ $player->team->name }}</td>
            </tr>
      @endforeach
  </tbody>
</table> 
<a class="btn btn-primary btn-lg pull-right" href="{{ Url::get('/coupon/players/update') }}" role="button">
            Change your players
</a>
