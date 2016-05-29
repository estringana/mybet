<div class="panel panel-default {{($editable?'editable':'')}}">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a role="button" data-toggle="{{$collapsable or ''}}" data-parent="#bets" href="#players" aria-expanded="false" aria-controls="players">{{ trans('messages.players') }}</a>
        </h4>        
    </div>
    <div class="panel-body {{$collapsable or ''}}" id="players">
        <table class="table table-responsive table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('messages.name') }}</th>
                    <th>{{ trans('messages.team') }}</th>
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
        @if (isset($editable) && $editable == true)
            <a class="btn btn-primary btn-lg pull-right" href="{{ Url::get('/coupon/players/update') }}" role="button">
                        {{ trans('messages.Changeyourplayers') }}
            </a>
        @endif
    </div>
</div>